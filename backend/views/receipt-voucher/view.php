<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ReceiptVoucher */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Receipt Vouchers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="receipt-voucher-view box box-primary">

    <div class="box-header">
        <?php /* Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary'])*/ ?>
        <?php /* Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) */?>
    </div>

    <div class="box-body table-responsive">
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'id',
            [
               'attribute'=>'recipient_type',
               'value'=> function($model) {
                       return \common\components\GeneralHelpers::translateParams(Yii::$app->params['recipient_type'][$model->recipient_type]);
                   }
            ],
            [
               'attribute'=>'owner_id',
               'value'=> function($model){
                return ($model->owner)? $model->owner->name:'';
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
            [
               'attribute'=>'maintenance_office_id',
               'value'=> function($model){
                return ($model->maintenanceOffice)? $model->maintenanceOffice->name:'';
              }
            ],
            [
              'attribute' =>'user_receipt_id',
              'value'=> function($model){
                return $model->userReceipt->name?? '';
              }
            ],
            'amount',
            'amount_text',
            // 'receipt_voucher_no',
             [
                'format' => 'html',
                'attribute' =>'pay_against',
            ],
            [
               'attribute'=>'payment_method',
               'value'=> function($model) {
                       return Yii::$app->params['PayMethod'][Yii::$app->language][$model->payment_method];
                   }
            ],
            'created_date',
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
                'attribute' =>'details',
            ],
        ],
    ]) ?>
    </div>
</div>
