<?php

use common\models\Installment;
use common\models\InstallmentReceiptCatchSearch;
use johnitvn\ajaxcrud\CrudAsset;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\InstallmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// print_r(ArrayHelper::map((clone $dataProvider)->query->groupBy(['renter_id'])->all(),'renter_id','renter.name')); die();
$this->title = Yii::t('app', 'Installments');
$this->params['breadcrumbs'][] = $this->title;
CrudAsset::register($this);

?>

    <div class="installment-index  box box-primary">

        <div id="ajaxCrudDatatable">
            <?= Yii::$app->view->renderFile('@backend/views/layouts/_filter_date.php', ['model' => $searchModel, 'label' => yii::t('app', 'Created Date')]); ?>

            <div class="box-body table-responsive">
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'id' => 'crud-datatable',
                    'pjax' => true,
                    'panel' => [
                        'after' => ''
                    ],
                    'rowOptions' => function ($model) {
                        switch ($model->payment_status) {
                            case Installment::STATUS_PAID:
                                return ['class' => 'success'];
                                break;
                            case Installment::STATUS_CANCEL:
                                return ['class' => 'danger'];
                                break;
                            case Installment::STATUS_PART_PAID:
                                return ['class' => 'warning'];
                                break;
                            default:
                                // code...
                                break;
                        }
                    },
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'class' => 'kartik\grid\ExpandRowColumn',
                            'value' => function ($model, $key, $index, $column) {
                                if ($model->installmentReceiptCatches) {
                                    return GridView::ROW_COLLAPSED;
                                }
                            },
                            'detail' => function ($model, $key, $index, $column) {
                                $searchModel = new InstallmentReceiptCatchSearch();
                                $searchModel->installment_id = $model->id;
                                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                                return Yii::$app->controller->renderPartial('_installment-receipt-catch', [
                                    'searchModel' => $searchModel,
                                    'dataProvider' => $dataProvider,
                                ]);
                            },
                            'expandAllTitle' => Yii::t('app', 'Expand All'),
                            'expandTitle' => Yii::t('app', 'Expand'),
                            'collapseTitle' => Yii::t('app', 'Collapse'),
                            'collapseAllTitle' => Yii::t('app', 'Collapse All'),
                        ],
                        [
                            'attribute' => 'contract_no',
                            'label' => yii::t('app', 'Contract No'),
                            'value' => 'contract.contract_no'
                        ],
                        // 'id',
                        // 'contract.contract_no',
                        // 'renter_id',
                        [
                            'attribute' => 'renter_id',
                            'filter' => ArrayHelper::map((new \common\models\UserSearch)->search([null, 'renter'])->query->andFilterWhere(['estate_office_id' => \common\components\GeneralHelpers::getEstateOfficeId()])
                                ->leftJoin('estate_office_renter', 'user.id = estate_office_renter.renter_id')->all(), 'id', 'name'),
                            'value' => 'renter.name',
                            'filterType' => GridView::FILTER_SELECT2,
                            'filterWidgetOptions' => [
                                'options' => ['prompt' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'width' => '100px'
                                ],
                            ],
                        ],
                        // [
                        //     'attribute' =>'renter_id',
                        //     'filter'=> ArrayHelper::map((new \common\models\UserSearch)->search([null,'renter'])->query->andFilterWhere(['estate_office_id' => \common\components\GeneralHelpers::getEstateOfficeId()])
                        //             ->leftJoin('estate_office_renter', 'user.id = estate_office_renter.renter_id')->all(),'id','name'),

                        //     'value'=> 'renter.name'
                        // ],
                        [
                            'label' => yii::t('app', 'Building'),
                            'filter' => ArrayHelper::map(\common\models\Building::find()->CurrentUser()->all(), 'id', 'building_name'),
                            'attribute' => 'building_id',
                            'value' => 'contract.building.building_name',
                            'filterType' => GridView::FILTER_SELECT2,
                            'filterWidgetOptions' => [
                                'options' => ['prompt' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'width' => '100px'
                                ],
                            ],
                        ],
                        // [
                        //     'attribute' =>'building_name',
                        //     'value'=> 'contract.building.building_name'
                        // ],
                        [
                            'label' => yii::t('app', 'Building Housing Unit'),
                            'attribute' => 'housing_unit_name',
                            'value' => 'contract.housingUnit.housing_unit_name'
                        ],
                        [
                            'label' => yii::t('app', 'Renter Mobile'),
                            'attribute' => 'renter_mobile',
                            'value' => 'renter.mobile'
                        ],
                        [
                            'attribute' => 'identity',
                            'label' => yii::t('app', 'Identity Id') . ' ' . yii::t('app', 'Renter'),
                            'value' => 'renter.identity_id'
                        ],
                        // [
                        //     'attribute' =>'renter_id',
                        //     'filter'=> ArrayHelper::map((clone $dataProvider)->query->groupBy(['renter_id'])->all(),'renter_id','renter.name'),
                        //     'value'=> 'renter.name'
                        // ],
                        'installment_no',
                        [
                            'attribute' => 'payment_status',
                            'filter' => Yii::$app->params['statusPayment2'][Yii::$app->language],
                            'value' => function ($model) {
                                return Yii::$app->params['statusPayment2'][Yii::$app->language][$model->payment_status];
                            }
                        ],
                        'amount',
                        'amount_paid',
                        'amount_remaining',
                        'start_date:date',
                        //'details:ntext',
                        //'amount_text',
                        // 'end_date',
                        [

                            'label' => yii::t('app', 'installment payment'),
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'text-align: center;'],
                            'value' => function ($models) {
                                // فحص تسديد القسط بالكامل لا يتم عرض خيار الدفع
                                if (!$models->isPaid()) {
                                    return Html::a('<span class="fa fa-plus-circle" aria-hidden="true"></span>',
                                        ['/installment-receipt-catch/create',
                                            'installment_id' => $models->id,
                                        ],
                                        ['data-pjax' => "0", 'class' => 'btn btn-social-icon'/*,'role'=>'modal-remote'*/]
                                    );
                                };
                                return '';
                            },
                            'visible' => yii::$app->user->can('/installment-receipt-catch/create'),
                        ],
                        [
                            'attribute' => 'payment_status_owner',
                            'filter' => false,
                            // 'filter'=> Yii::$app->params['statusPayment2'][Yii::$app->language],
                            'value' => function ($model) {
                                return Yii::$app->params['statusPayment2'][Yii::$app->language][$model->payment_status_owner];
                            },
                            'visible' => yii::$app->user->can('/installment-receipt-catch/create'),
                        ],
                        [
                            'attribute' => 'amount_remaining_owner',
                            'filter' => false,
                            'visible' => yii::$app->user->can('/installment-receipt-catch/create'),
                        ],
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'header' => yii::t('app', ""),
                            'dropdown' => false,
                            'template' => (yii::$app->user->can('/installment/delete')) ? '{view} {update}{delete}' : '{view} ',
                            // 'template' => '{view} ',
                            'vAlign' => 'middle',
                            'urlCreator' => function ($action, $model, $key, $index) {
                                return Url::to([$action, 'id' => $key]);
                            },
                            'viewOptions' => [/*'role'=>'modal-remote',*/ 'title' => 'View'/*,'data-toggle'=>'tooltip'*/],
                            //'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
                            'deleteOptions' => ['role' => 'modal-remote', 'title' => 'Delete',
                                'data-confirm' => false, 'data-method' => false,// for overide yii data api
                                'data-request-method' => 'post',
                                'data-toggle' => 'tooltip',
                                'data-confirm-title' => 'Are you sure?',
                                'data-confirm-message' => 'Are you sure want to delete this item'],
                        ],

                        // ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>

            </div>
        </div>

    </div>
<?php Modal::begin([
    "id" => "ajaxCrudModal",
    "footer" => "",// always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>