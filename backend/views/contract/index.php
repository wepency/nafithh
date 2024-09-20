<?php

use yii\helpers\Html;
use common\models\Installment;
use johnitvn\ajaxcrud\BulkButtonWidget;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel common\models\ContractSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contracts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contract-index  box box-primary">
    <?php if (yii::$app->user->can('/contract/add-contract')) { ?>
        <div class="box-header with-border">
            <?= Html::a(Yii::t('app', 'Create Contract'), ['add-contract'], ['class' => 'btn btn-success']) ?>
        </div>
    <?php } ?>
    <?= Yii::$app->view->renderFile('@backend/views/layouts/_filter_date.php', ['model' => $searchModel, 'label' => yii::t('app', 'Created Date')]); ?>
    <?php Pjax::begin(); ?>

    <div class="box-body table-responsive">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'rowOptions' => function ($model) {
                if ($model->is_draft == 1) {
                    return ['class' => 'danger'];
                }
            },
            'pjax' => true, // pjax is set to always true for this demo
            'pjaxSettings' => [
                'neverTimeout' => true,
                'options' => [
                    'id' => 'p0',
                ]
            ],
            'panel' => [
                'after' => ''
            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'contract_no',
                // 'estateOffice.name',
                [
                    'attribute' => 'estate_office_name',
                    'label' => yii::t('app', 'Estate Office'),
                    'value' => 'estateOffice.name'
                ],
                [
                    'label' => yii::t('app', 'Owner Name'),
                    'attribute' => 'owner_name',
                    'value' => 'owner.name'
                ],
                // ['attribute'=>'building_id','value'=> 'building.building_name'],
                [
                    'attribute' => 'building_id',
                    'filter' => ArrayHelper::map(\common\models\Building::find()->CurrentUser()->all(), 'id', 'building_name'),
                    'value' => 'building.building_name'
                ],
                [
                    'attribute' => 'housing_unit_id',
                    'filter' => false,
                    'value' => 'housingUnit.housing_unit_name'
                ],
                [
                    'label' => 'رقم عقد منصة إيجار',
                    'attribute' => 'contract_no_ejar',
                    'value' => 'contract_no_ejar',
                ],
                [
                    'label' => yii::t('app', 'Renter Name'),
                    'attribute' => 'renter_name',
                    'value' => 'renter.name'
                ],
                //'housing_unit_id',
                //'renter_id',
                //'rent_peroid_id',
                //'housing_using_type_id',
                //'contract_form_id',
                //'user_created_id',
                //'refrence_contract_id',
                //'contract_info_json:ntext',
                //'created_date',
                'start_date',
                'end_date',
                'price',
                [
                    'attribute' => 'is_active',
                    'filter' => Yii::$app->params['yesNo'][Yii::$app->language],
                    'value' => function ($model) {
                        return Yii::$app->params['yesNo'][Yii::$app->language][$model->is_active];
                    }
                ],
                [
                    'attribute' => 'is_draft',
                    'filter' => Yii::$app->params['yesNo'][Yii::$app->language],
                    'label' => yii::t('app', 'Is Draft'),
                    'value' => function ($model) {
                        return Yii::$app->params['yesNo'][Yii::$app->language][$model->is_draft];
                    }
                ],
                [
                    'label' => yii::t('app', 'Number') . ' ' . yii::t('app', 'Installments'),
                    'filter' => false,
                    'value' => function ($model) {
                        return count($model->installments);
                    }
                ],
                [
                    'label' => yii::t('app', 'Number') . ' ' . yii::t('app', 'Installments Paid'),
                    'filter' => false,
                    'value' => function ($model) {
                        return Installment::find()->where(['contract_id' => $model->id, 'payment_status' => Installment::STATUS_PAID])->count();
                    }
                ],
                [
                    'label' => yii::t('app', 'Contract Ending'),
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'text-align: center;'],
                    'value' => function ($model) {
                        if ($model->is_active === 1) {
                            return Html::a('<span class="fa fa-window-close-o" aria-hidden="true"></span>',
                                ['/contract/ending',
                                    'id' => $model->id,
                                ],
                                ['data-pjax' => "0",
                                    'class' => 'btn btn-social-icon',
                                    'data' => [
                                        'confirm' => Yii::t('app', 'Are you sure you want to Ending and close the contract?') . ' <br> ' . Yii::t('app', 'If you Ending the contract, the following procedures will be applied: making the unit available for rent, canceling all unpaid installments only, and keeping the contract and paid and canceled installments'),
                                        'method' => 'post'],
                                ],
                            );
                        };
                        return '';
                    },
                    'visible' => yii::$app->user->can('/contract/ending'),
                ],
                [
                    'label' => yii::t('app', 'Brokerage Amount'),
                    'filter' => false,
                    'value' => function ($model) {
                        if ($model->brokerage_type == 1) {
                            return $model->brokerage_value . ' %';
                        }
                        return $model->brokerage_value;
                    },
                    'visible' => yii::$app->user->can('developer'),
                ],
                // [
                //     'label' => yii::t('app','Contract Renew'),
                //     'format' => 'raw',
                //     'contentOptions' => ['style' => 'text-align: center;'],
                //     'value'=> function($model) {
                //         if($model->is_active === 1 ){
                //             return Html::a('<span class="fa fa-window-close-o" aria-hidden="true"></span>',
                //                 ['/contract/ending',
                //                     'id' => $model->id,
                //                 ],
                //                 ['data-pjax'=>"0",
                //                     'class' => 'btn btn-social-icon' ,
                //                     'data' => ['method' => 'post'],
                //                 ],
                //             );
                //         };
                //         return '';
                //     },
                //     'visible' => yii::$app->user->can('/contract/ending'),
                // ],
                //'price_text',
                //'added_tax',
                //'insurance_amount',
                //'include_water',
                //'include_electricity',
                //'include_maintenance',
                //'status',
                //'is_active',
                //'is_draft',
                //'number_installments',
                //'details:ntext',

                ['class' => 'kartik\grid\ActionColumn',
                    // 'template' => yii::$app->user->can('/contract/delete')? '{view} {renew} {update} {delete} ' : (yii::$app->user->can('/contract/update')? '{view} {update}' :'{view}') ,
                    'template' => (yii::$app->user->can('/contract/delete') ? '{view} {update} {delete} ' : (yii::$app->user->can('/contract/update') ? '{view} {update} ' : '{view} ')) . (yii::$app->user->can('/contract/renew') ? '{renew}' : ''),
                    'urlCreator' => function ($action, $model, $key, $index) {
                        return Url::to([$action, 'id' => $key]);
                    },
                    'buttons' => [
                        'renew' => function ($url, $model, $key) {
                            $peroidDay = 30;
                            $nowAfter = strtotime("+$peroidDay days");
                            $end_date = strtotime($model->end_date);
                            if ($nowAfter > $end_date) {
                                return Html::a('<span class="glyphicon glyphicon-duplicate"></span>', ['renew', 'id' => $model->id], ['title' => yii::t('app', 'Renew')]);
                            } else {
                                return '';
                            }
                        },
                        'generate_installments' => function ($url, $model, $key) {
                            if (count($model->installments) == 0) {
                                return Html::a(
                                    '<span class="glyphicon glyphicon-refresh"></span>',
                                    ['generate-installments', 'contractId' => $model->id], // Action for POST request
                                    [
                                        'title' => Yii::t('app', 'Generate Installments'),
                                        'data-method' => 'post', // This makes the request a POST request
                                        'data-confirm' => Yii::t('app', 'Are you sure you want to generate installments?'), // Confirmation dialog
                                    ]
                                );
                            }

                            return '';
                        },
                    ],
                ],
            ],
        ]); ?>

    </div>
    <?php Pjax::end(); ?>
</div>
