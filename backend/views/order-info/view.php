<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\OrderInfo */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Order Infos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="order-info-view box box-primary">
<?php /*
    <div class="box-header">
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>
*/?>
    <div class="box-body table-responsive">
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'id',
            'title',
            [
               'attribute'=>'maintenance_type_id',
               'value'=> function($model){
                return ($model->maintenanceType)? $model->maintenanceType->_name:'';
              }
            ],
            [
               'attribute'=>'estate_office_id',
               'value'=> function($model){
                    return ($model->estateOffice)? $model->estateOffice->name:'';
              }
            ],
            [
               'attribute'=>'building_housing_unit_id',
               'value'=> function($model){
                return ($model->buildingHousingUnit)? $model->buildingHousingUnit->housing_unit_name:'';
              }
            ],
            // [
            //   'attribute' =>'sender_id',
            //   'value'=> function($model){
            //     return ($model->sender)? $model->sender->name : ($model->estateOffice)? $model->estateOffice->name:'';
            //   }
            // ],
            [
               'attribute'=>'sender_id',
                'value'=> function($model) {
                  return Yii::$app->params['userType'][Yii::$app->language][$model->sender_type].' - '.
                    $model->sender->name;
                }
            ],
            // 'sender_type',
            [
               'attribute'=>'send_to',
                'filter'=> false,
                'value'=> function($model) {
                  return Yii::$app->params['userType'][Yii::$app->language][$model->send_to];
                }
            ],
            [
               'attribute'=>'is_draft',
               'label'=>yii::t('app','Is Draft'),
               'value'=> function($model) {
                       return Yii::$app->params['yesNo'][Yii::$app->language][$model->is_draft];
                   }
            ],

            [
                'format'=>'raw',
                'label'=>yii::t('app','Attachments'),
                'value'=> function($model) {
                    $attWidget =  new \common\components\MultiAttachmentWidget(['model'=>$model]);
                    return $attWidget->runForView();
                }
            ],
            [
                'format' => 'html',
                'attribute' =>'details_order',
            ],
            // 'details_order:ntext',
            'created_date',
        ],
    ]) ?>
    </div>
</div>
