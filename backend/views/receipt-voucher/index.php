<?php

use yii\helpers\Html;

use johnitvn\ajaxcrud\BulkButtonWidget;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ReceiptVoucherSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Receipt Vouchers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="receipt-voucher-index  box box-primary">

    <?php if(yii::$app->user->can('/receipt-voucher/create')){ ?>
      <div class="box-header with-border">
        <?= Html::a(Yii::t('app', 'Create Receipt Voucher'), ['create'], ['class' => 'btn btn-success']) ?>
      </div>
    <?php } ?>
    <div class="box-body table-responsive"> 
      <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

      <?=Yii::$app->view->renderFile('@backend/views/receipt-voucher/_filter_date.php',['model'=>$searchModel,'label'=>yii::t('app','Created Date')]);?>

      <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
          'after'=>''
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
               'attribute'=>'recipient_type',
               'filter'=> \common\components\GeneralHelpers::translateParams(Yii::$app->params['recipient_type']),
               'value'=> function($model) {
                       return \common\components\GeneralHelpers::translateParams(Yii::$app->params['recipient_type'][$model->recipient_type]);
                   }
            ],
            [
                'label' => yii::t('app', 'Recipient Name'),
                'attribute' => 'recipient_name',
                'value' => function ($model) {
                    return match ($model->recipient_type) {
                        'owner' => $model?->buildingHousingUnit?->building?->owner?->name ?? $model?->owner?->name,
                        'maintenance_office' => $model?->maintenanceOffice?->name,
                        default => $model?->recipient_name
                    };
                },
            ],
//            [
//                'label' =>yii::t('app','Owner Name'),
//                'attribute' =>'owner_name',
//                'value' => function($model) {
//                    return $model->buildingHousingUnit?->building?->owner?->name ?? $model->owner?->name;
//                },
//            ],
            [
                'label' =>yii::t('app','Building'),
                'attribute'=>'building_name',
                'filter'=> true,
                'value'=> 'buildingHousingUnit.building.building_name'
            ],
            [
                'label' =>yii::t('app','Building Housing Unit'),
                'attribute'=>'housing_unit_name',
                'filter'=> true,
                'value'=> 'buildingHousingUnit.housing_unit_name'
            ],
//            [
//               'attribute'=>'maintenance_office_id',
//               'filter'=> true,
//               'value'=> 'maintenanceOffice.name'
//            ],
            'amount',
            'amount_text',
            [
              'attribute' =>'user_receipt_id',
              'filter' => true,
              'value'=> function($model){
                return $model?->userReceipt?->name;
              }
            ],
            [
               'attribute'=>'payment_method',
               'filter'=> Yii::$app->params['PayMethod'][Yii::$app->language],
               'value'=> function($model) {
                       return Yii::$app->params['PayMethod'][Yii::$app->language][$model->payment_method];
                   }
            ],
            [
               'attribute'=>'estate_office_id',
               'filter'=> true,
               'value'=> 'estateOffice.name'
            ],
            [
               'attribute'=>'payment_status_estate',
               'filter'=> true,
               // 'filter'=> Yii::$app->params['statusPayment2'][Yii::$app->language],
               'value'=> function($model) {
                       return Yii::$app->params['statusPayment2'][Yii::$app->language][$model->payment_status_estate];
                },
                'visible' => yii::$app->user->can('developer'),
            ],
            [
                'format' => 'html',
                'attribute' =>'pay_against',
            ],
            'created_date',
            //'receipt_voucher_no',
            //'pay_against:ntext',
            //'payment_method',
            //'user_receipt_id',
            //'created_date',
            //'details:ntext',

            ['class' => 'kartik\grid\ActionColumn',
              'template' => '{view}',
            ],
        ],
    ]); ?>

    </div>
</div>
