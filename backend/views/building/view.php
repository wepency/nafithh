<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Building */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Buildings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="building-view box box-primary">
    <div class="box-header">
        <?php /*<?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ])*/ ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                [
                    'attribute' => 'owner_id',
                    'label' => Yii::t('app', 'Owner Name'),
                    'value' => $model?->owner?->name ?? '--',
                ],
                [
                    'label' => Yii::t('app', 'Estate Office Name'),
                    'value' => $model?->estateContract?->estateOffice?->name ?? '--',
                ],
                'instrument_number',
                'building_name',
                [
                    'attribute' => 'building_type_id',
                    'value' => $model?->buildingType?->_name ?? '--',
                ],
                'floors',
                'housing_units',
                [
                    'attribute' => 'city_id',
                    'value' => $model?->city?->_name ?? '--',
                ],
                [
                    'attribute' => 'district_id',
                    'value' => $model?->district?->_name ?? '--',
                ],
                'lang',
                'lat',
                [
                    'attribute' => 'building_status',
                    'value' => Yii::t('app', $model?->building_status) ?? '--',
                ],
                'building_age',
                [
                    'format' => 'html',
                    'attribute' => 'description',
                    'value' => $model?->description ?? '--',
                ],
                [
                    'attribute' => 'housing_units_available',
                    'value' => count($model?->buildingHousingUnitsAvailable) ?? '--',
                ],
                [
                    'attribute' => 'housing_units_rented',
                    'value' => count($model?->buildingHousingUnitsRented) ?? '--',
                ],
                'has_parking',
                [
                    'attribute' => 'ad_subtype',
                    'value' => Yii::$app->params['adsubtype'][Yii::$app->language][$model?->ad_subtype] ?? '--',
                ],
                'rent_price',
                'sale_price',
                'invest_price',
                [
                    'attribute' => 'for_rent',
                    'value' => Yii::$app->params['yesNo'][Yii::$app->language][$model?->for_rent] ?? '--',
                    'visible' => yii::$app->user->can('/building/update'/*,['building'=>$model?->building]*/),
                ],
                [
                    'attribute' => 'for_sale',
                    'value' => Yii::$app->params['yesNo'][Yii::$app->language][$model?->for_sale] ?? '--',
                    'visible' => yii::$app->user->can('/building/update'/*,['building'=>$model?->building]*/),
                ],
                [
                    'attribute' => 'for_invest',
                    'value' => Yii::$app->params['yesNo'][Yii::$app->language][$model?->for_invest] ?? '--',
                    'visible' => yii::$app->user->can('/building/update'/*,['building'=>$model?->building]*/),
                ],
                [
                    'attribute' => 'ad_status',
                    'label' => Yii::t('app', 'Status'),
                    'value' => Yii::$app->params['statusCase'][Yii::$app->language][$model?->ad_status] ?? '--',
                ],
                'updated_at:date',
                'annual_income',
            ],
        ]) ?>

    </div>
</div>
