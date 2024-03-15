<?php

use common\models\PollQuestion;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PollAnswerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>
<div class="box-body table-responsive">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'filterModel' => $searchModel,
        // 'layout' => "{summary}\n{items}\n{pager}",
        'rowOptions' => function ($model) {
            if ($model->status == 1) {
                return ['class' => 'success'];
            }
        },
        'columns' => [

            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            // 'id',
            // 'building_id',
            'housing_unit_name',
            'floors_no',
            'rent_price',

//            [
//                'attribute' => 'ad_subtype',
//                'filter' => Yii::$app->params['adsubtype'][Yii::$app->language],
//                'value' => function ($model) {
//                    return Yii::$app->params['adsubtype'][Yii::$app->language][$model->ad_subtype];
//                }
//            ],
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
                'attribute' => 'status',
                'filter' => Yii::$app->params['statusHousRent'][Yii::$app->language],
                'label' => yii::t('app', 'Status'),
                'value' => function ($model) {
                    return Yii::$app->params['statusHousRent'][Yii::$app->language][$model->status];
                }
            ],
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
            // 'area',
            // 'rooms',
            // 'entrances',
            // 'has_parking',
            // 'toilets',
            // 'kitchen',
            // 'furniture',
            // 'conditioner_num',
            // 'pool',
            // 'detail',
            // 'using_for',
            // 'status',
            // 'sale_price',

        ],
    ]); ?>


</div>
