<?php

use common\models\Building;
use common\models\BuildingType;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BuildingHousingUnitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Building Housing Units');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="building-housing-unit-index box box-primary">
    <?php Pjax::begin(); ?>
    <?php if (yii::$app->user->can('/building/create')) { ?>
        <div class="box-header with-border">
            <?= Html::a(Yii::t('app', 'Create Building Housing Units'), ['create'], ['class' => 'btn btn-success btn-flat']) ?>
        </div>
    <?php } ?>

    <div class="box-body table-responsive">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{summary}\n{items}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                [
                    'label' => yii::t('app', 'Building'),
                    'attribute' => 'building_id',
                    // filter false for renter , true for all
                    'filter' => yii::$app->user->can('/building/update') ? ArrayHelper::map(Building::find()->CurrentUser()->all(), 'id', 'building_name') : false,
                    'value' => function ($model) {
                        return $model->building->building_name;
                    },
                ],
                'housing_unit_name',
                'floors_no',
//                'rent_price',
                'rooms',
                // 'area',
                [
                    'attribute' => 'building_type_id',
                    'filter' => ArrayHelper::map(BuildingType::find()->where(['>', 'id', 0])->all(), 'id', '_name'),
                    'value' => 'buildingType._name',
                    'headerOptions' => ['style' => 'width:6%'],
                ],

                [
                    'attribute' => 'using_for',
                    'filter' => Yii::$app->params['renterType'][Yii::$app->language],
                    'value' => function ($model) {
                        if (isset($model->using_for)) {
                            return Yii::$app->params['renterType'][Yii::$app->language][$model->using_for];
                        }

                        return '--';
                    }
                ],
                [
                    'label' => yii::t('app', 'Renter Status'),
                    'attribute' => 'status',
                    'filter' => Yii::$app->params['statusHousRent'][Yii::$app->language],
                    'value' => function ($model) {
                        return Yii::$app->params['statusHousRent'][Yii::$app->language][$model->status];
                    },
                    'visible' => yii::$app->user->can('/building/update'/*,['building'=>$model->building]*/),
                ],
//                [
//                    'label' => Yii::t('app', 'for sale - for renting - for investing'),
//                    'attribute' => 'ad_subtype',
//                    'filter' => Yii::$app->params['adsubtype'][Yii::$app->language],
//                    'value' => function ($model) {
//                        return Yii::$app->params['adsubtype'][Yii::$app->language][$model->ad_subtype];
//                    }
//                ],
                [
                    'label' => Yii::t('app', 'for sale - for renting - for investing'),
                    'attribute' => 'ad_subtype',
                    'filter' => Yii::$app->params['adsubtype'][Yii::$app->language],
                    'format' => 'html',
                    'value' => function ($model) {
                        $out = '<div style="text-align:center">';

                        if ($model->for_rent) {
                            $out .= "<p>للإيجار</p>";
                        }

                        if ($model->for_sale) {
                            $out .= "<p>للبيع</p>";
                        }

                        if ($model->for_invest) {
                            $out .= "<p>للاستثمار</p>";
                        }

                        $out .= "</div>";

                        return $out;
                    }
                ],
                [
                    'label' => Yii::t('app', 'Price'),
                    'format' => 'html', // Set the format to 'html'
                    'attribute' => 'rent_price',
                    'filter' => true,
                    'headerOptions' => ['style' => 'min-width:120px'],
                    'value' => function ($model) {
                        $out = '<div style="text-align:center">';

                        if ($model->for_rent) {
                            $out .= "<p>$model->rent_price</p>";
                        }

                        if ($model->for_sale) {
                            $out .= "<p>$model->sale_price</p>";
                        }

                        if ($model->for_invest) {
                            $out .= "<p>$model->invest_price</p>";
                        }

                        $out .= "</div>";

                        return $out;
                    }
                ],
//                [
//                   'attribute'=>'sale_price',
//                   'value'=> 'sale_price',
//                    'visible' => yii::$app->user->can('/building/update'/*,['building'=>$model->building]*/),
//                ],
                'entrances',
                // [
                //    'attribute'=>'pool',
                //     'filter'=> Yii::$app->params['yesNo'][Yii::$app->language],
                //    'value'=> function($model) {
                //            return Yii::$app->params['yesNo'][Yii::$app->language][$model->pool];
                //        }
                // ],
                [
                    'attribute' => 'kitchen',
                    'filter' => Yii::$app->params['yesNo'][Yii::$app->language],
                    'value' => function ($model) {
                        return Yii::$app->params['yesNo'][Yii::$app->language][$model->kitchen];
                    }
                ],
//                [
//                    'attribute' => 'ad_status',
//                    'filter' => Yii::$app->params['statusCase'][Yii::$app->language],
//                    'label' => yii::t('app', 'Status'),
//                    'value' => function ($model) {
//                        return Yii::$app->params['statusCase'][Yii::$app->language][$model->ad_status] ?? '';
//                    }
//                ],
                // [
                //    'attribute'=>'has_parking',
                //     'filter'=> Yii::$app->params['yesNo'][Yii::$app->language],
                //    'value'=> function($model) {
                //            return Yii::$app->params['yesNo'][Yii::$app->language][$model->has_parking];
                //        }
                // ],
                [

                    'label' => Yii::t('app', 'Create Order Maintenance'),
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'text-align: center;'],
                    'value' => function ($models) {
                        // if(!$models->isPaid()){
                        return Html::a('<span class="fa fa-plus-circle" aria-hidden="true"></span>',
                            ['/order-info/create',
                                'housing_id' => $models->id,
                            ],
                            ['class' => 'btn btn-social-icon']
                        );
                        // };
                        return '';
                    },
                ],
                [

                    'label' => Yii::t('app', 'Create Contract'),
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'text-align: center;'],
                    'value' => function ($models) {
                        if ($models->status == 0) {
                            return Html::a('<span class="fa fa-plus-circle" aria-hidden="true"></span>',
                                ['/building-housing-unit/create-contract',
                                    'id' => $models->id,
                                ],
                                ['class' => 'btn btn-social-icon', 'target' => '_blank']
                            );
                        };
                        return '';
                    },
                    'visible' => yii::$app->user->can('/contract/create'),
                ],
                // 'toilets',
                // 'furniture',
                // 'conditioner_num',
                // 'detail',

                ['class' => 'yii\grid\ActionColumn',
                    'template' => yii::$app->user->can('/building-housing-unit/delete') ? '{view} {duplicat} {update} {delete} ' : (yii::$app->user->can('/building-housing-unit/update') ? '{view} {update} {duplicat} ' : '{view}'),
                    'urlCreator' => function ($action, $model, $key, $index) {
                        return Url::to([$action, 'id' => $key]);
                    },
                    'buttons' => [
                        'duplicat' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-duplicate"></span>', ['create', 'id' => $model->id], ['title' => yii::t('app', 'Duplicate')]);
                        },
                    ],
                ],
            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>
</div>
