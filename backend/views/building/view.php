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
                ['attribute'=>'owner_id','label'=>yii::t('app','Owner Name'),'value'=> function($model) {return $model->owner->name;} ],
                [
                    'label'=>yii::t('app','Estate Office Name'),
                    'value'=> function($model) {return $model->estateContract->estateOffice->name?? '';}
                ],
                'instrument_number',
                'building_name',
                ['attribute'=>'building_type_id','value'=>function($model) {return $model->buildingType->_name;}],
                'floors',
                'housing_units',
                ['attribute'=>'city_id','value'=>function($model) {return $model->city->_name;}],
                ['attribute'=>'district_id','value'=>function($model) {return $model->district->_name;}],
                'lang',
                'lat',
				[
				   'attribute'=>'building_status',
				   'value'=> function($model) {
						   return Yii::t('app',$model->building_status);
					   }
				],
                'building_age',
                [
                'format' => 'html',
                'attribute' =>'description',
                ],
                [
                   'attribute'=>'housing_units_available',
                   'value'=> function($model) {
                           return count($model->buildingHousingUnitsAvailable);
                       }
                ],
                [
                   'attribute'=>'housing_units_rented',
                   'value'=> function($model) {
                           return count($model->buildingHousingUnitsRented);
                       }
                ],
                // 'housing_units_available',
                // 'housing_units_rented',
                'has_parking',
                [
                    'attribute' =>'ad_subtype',
                    'value'=> function($model)
                    {
                        return Yii::$app->params['adsubtype'][Yii::$app->language][$model->ad_subtype];
                    }
                ],
                'rent_price',
                'sale_price',
                'invest_price',
                [
                   'attribute'=>'for_rent',
                   'value'=> function($model) {
                           return Yii::$app->params['yesNo'][Yii::$app->language][$model->for_rent];
                       },
                    'visible' => yii::$app->user->can('/building/update'/*,['building'=>$model->building]*/),

                ],
                [
                   'attribute'=>'for_sale',
                   'value'=> function($model) {
                           return Yii::$app->params['yesNo'][Yii::$app->language][$model->for_sale];
                       },
                    'visible' => yii::$app->user->can('/building/update'/*,['building'=>$model->building]*/),
                ],
                [
                   'attribute'=>'for_invest',
                   'value'=> function($model) {
                           return Yii::$app->params['yesNo'][Yii::$app->language][$model->for_invest];
                       },
                    'visible' => yii::$app->user->can('/building/update'/*,['building'=>$model->building]*/),
                ],
				[
				   'attribute'=>'ad_status',
				   'label'=>yii::t('app','Status'),
				   'value'=> function($model) {
						   return Yii::$app->params['statusCase'][Yii::$app->language][$model->ad_status];
					   }
				],
                'updated_at:date',
                'annual_income',
            ],
        ]) ?>
    </div>
</div>
