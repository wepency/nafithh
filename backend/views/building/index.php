<?php

use common\models\BuildingHousingUnitSearch;
use common\models\BuildingType;
use common\models\City;
use common\models\District;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BuildingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Buildings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="building-index box box-primary">
    <?php Pjax::begin(); ?>
    <?php if (yii::$app->user->can('/building/create')) { ?>
        <div class="box-header with-border">
            <?= Html::a(Yii::t('app', 'Create Building'), ['create'], ['class' => 'btn btn-success btn-flat']) ?>
        </div>
    <?php } ?>
    <div class="box-body table-responsive">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax' => true, // pjax is set to always true for this demo
            'pjaxSettings' => [
                'neverTimeout' => true,
                'options' => [
                    'id' => 'p0',
                ]
            ],
            'layout' => "{summary}\n{items}\n{pager}",
            'columns' => [

                ['class' => 'yii\grid\SerialColumn'],
                [
                    'class' => 'kartik\grid\ExpandRowColumn',
                    'value' => function ($model, $key, $index, $column) {
                        if ($model->buildingHousingUnits) {
                            return GridView::ROW_COLLAPSED;
                        }
                    },
                    'detail' => function ($model, $key, $index, $column) {
                        $searchModel = new BuildingHousingUnitSearch();
                        $searchModel->building_id = $model->id;
                        //$searchModel-> total = $model->total;
                        //$searchModel-> manager = $model->manager;
                        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                        return Yii::$app->controller->renderPartial('_housing_unit', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                        ]);

                    },
                ],

                // 'id',
                [
                    'attribute' => 'owner_name',
                    'label' => yii::t('app', 'Owner Name'),
                    'value' => 'owner.name',
                    'headerOptions' => ['style' => 'width:9%'],
                    'visible' => yii::$app->user->can('/building/create') || yii::$app->user->can('admin'),

                ],
                [
                    'attribute' => 'instrument_number',
                    'headerOptions' => ['style' => 'width:7%'],
                ],
                [
                    'attribute' => 'building_name',
                    'headerOptions' => ['style' => 'width:7%'],
                ],
                [
                    'attribute' => 'housing_units_available',
                    'filter' => false,
                    'value' => function ($model) {
                        return count($model->buildingHousingUnitsAvailable);
                    },
                    'headerOptions' => ['style' => 'width:6%'],
                ],
                [
                    'attribute' => 'housing_units_rented',
                    'filter' => false,
                    'value' => function ($model) {
                        return count($model->buildingHousingUnitsRented);
                    },
                    'headerOptions' => ['style' => 'width:6%'],
                ],
                [
                    'attribute' => 'building_type_id',
                    'filter' => ArrayHelper::map(BuildingType::find()->where(['>', 'id', 0])->all(), 'id', '_name'),
                    'value' => 'buildingType._name',
                    'headerOptions' => ['style' => 'width:6%'],

                ],
                [
                    'attribute' => 'city_id',
                    'filter' => ArrayHelper::map(City::find()->where(['>', 'id', 0])->all(), 'id', '_name'),
                    'value' => 'city._name',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'options' => ['prompt' => ''],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'width' => '100px'
                        ],
                    ],
                ],
                [
                    'attribute' => 'district_id',
                    'filter' => ArrayHelper::map(District::find()->where(['>', 'id', 0])->all(), 'id', '_name'),
                    'value' => 'district._name',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'options' => ['prompt' => ''],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'width' => '100px'
                        ],
                    ],
                ],
                // 'floors',
                // 'housing_units',
                // 'lang',
                // 'lat',
                // 'building_age',
                // 'description:ntext',
                //      [
                // 'attribute'=>'building_status',
                // 'filter'=> Yii::$app->params['buildingStatus'][Yii::$app->language],
                // 'value'=> function($model) {
                //   return Yii::$app->params['buildingStatus'][Yii::$app->language][$model->building_status];
                //  }
                //      ],
                [
                    'attribute' => 'ad_status',
                    'filter' => Yii::$app->params['statusCase'][Yii::$app->language],
                    'label' => yii::t('app', 'Status'),
                    'value' => function ($model) {
                        return Yii::$app->params['statusCase'][Yii::$app->language][$model->ad_status];
                    }
                ],
//                [
//                    'label' => Yii::t('app', 'for sale - for renting - for investing'),
//                    'attribute' => 'for_rent',
//                    'filter' => Yii::$app->params['adsubtype'][Yii::$app->language],
//                    'value' => function ($model) {
//                        return Yii::$app->params['adsubtype'][Yii::$app->language][$model->ad_subtype];
//                    }
//                ],
                [
                    'label' => Yii::t('app', 'for sale - for renting - for investing'),
                    'attribute' => 'for_rent',
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
                [

                    'label' => Yii::t('app', 'Create Building Housing Units'),
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'text-align: center;'],
                    'value' => function ($models) {
                        // if(!$models->isPaid()){
                        return Html::a('<span class="fa fa-plus-circle" aria-hidden="true"></span>',
                            ['/building-housing-unit/create',
                                'building_id' => $models->id,
                            ],
                            ['class' => 'btn btn-social-icon']
                        );
                        // };
                        return '';
                    },
                    'visible' => yii::$app->user->can('/building-housing-unit/create'),
                ],
                // 'housing_units_available',
                // 'housing_units_rented',
                // 'has_parking',
                // 'rent_price',
                // 'sale_price',
                // 'updated_at',

                ['class' => 'yii\grid\ActionColumn',
                    'template' => yii::$app->user->can('/building/delete') ? '{view} {update} {delete} ' : (yii::$app->user->can('/building/update') ? '{view} {update}' : '{view}'),
                ],
            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>
</div>
