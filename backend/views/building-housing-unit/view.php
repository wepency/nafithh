<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\BuildingHousingUnit */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Building Housing Units'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="building-housing-unit-view box box-primary">
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                [
                    'attribute' => 'building_id',
                    'value' => function ($model) {
                        return $model->building->building_name;
                    },
                ],
                'housing_unit_name',
                'floors_no',
                [
                    'attribute' => 'building_type_id',
                    'value' => function ($model) {
                        return $model?->buildingType?->_name;
                    },
                ],
                'rent_price',
                'space',
                'rooms',
                'entrances',
                'toilets',
                [
                    'format' => 'html',
                    'attribute' => 'furniture',
                ],
                // 'furniture',
                'conditioner_num',
                [
                    'attribute' => 'pool',
                    'value' => function ($model) {
                        return Yii::$app->params['yesNo'][Yii::$app->language][$model->pool] ?? '--';
                    }
                ],
                [
                    'attribute' => 'kitchen',
                    'value' => function ($model) {
                        return Yii::$app->params['yesNo'][Yii::$app->language][$model->kitchen] ?? '--';
                    }
                ],
                [
                    'attribute' => 'has_parking',
                    'value' => function ($model) {
                        return Yii::$app->params['yesNo'][Yii::$app->language][$model->has_parking] ?? '--';
                    },
                ],
                [
                    'format' => 'html',
                    'attribute' => 'detail',
                ],
                [
                    'attribute' => 'using_for',
                    'value' => function ($model) {
                        return Yii::$app->params['renterType'][Yii::$app->language][$model->using_for] ?? '--';
                    },
                ],
                [
                    'attribute' => 'status',
                    'value' => function ($model) {
                        return Yii::$app->params['statusHousRent'][Yii::$app->language][$model->status] ?? '--';
                    },
                    'visible' => Yii::$app->user->can('/building/view'/*,['building'=>$model->building]*/),
                ],
                [
                    'attribute' => 'for_rent',
                    'value' => function ($model) {
                        return Yii::$app->params['yesNo'][Yii::$app->language][$model->for_rent] ?? '--';
                    },
                    'visible' => Yii::$app->user->can('/building/update'/*,['building'=>$model->building]*/),
                ],
                [
                    'attribute' => 'for_sale',
                    'value' => function ($model) {
                        return Yii::$app->params['yesNo'][Yii::$app->language][$model->for_sale] ?? '--';
                    },
                    'visible' => Yii::$app->user->can('/building/update'/*,['building'=>$model->building]*/),
                ],
                [
                    'attribute' => 'for_invest',
                    'value' => function ($model) {
                        return Yii::$app->params['yesNo'][Yii::$app->language][$model->for_invest] ?? '--';
                    },
                    'visible' => Yii::$app->user->can('/building/update'/*,['building'=>$model->building]*/),
                ],
                [
                    'attribute' => 'ad_subtype',
                    'value' => function ($model) {
                        return Yii::$app->params['adsubtype'][Yii::$app->language][$model->ad_subtype] ?? '--';
                    }
                ],
                [
                    'attribute' => 'sale_price',
                    'visible' => Yii::$app->user->can('/building/view'/*,['building'=>$model->building]*/),
                ],
                'electricity_meter_no',
                'water_meter_no',
            ],
        ]) ?>
    </div>
</div>