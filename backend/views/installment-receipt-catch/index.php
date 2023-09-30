<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\InstallmentReceiptCatchSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Installment Receipt Catches');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="installment-receipt-catch-index  box box-primary">

<?=Yii::$app->view->renderFile('@backend/views/layouts/_filter_date.php',['model'=>$searchModel,'label'=>yii::t('app','Created Date')]);?>
    
    <div class="box-body table-responsive"> 
      <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'installment_id',
            [
              'attribute' =>'user_receive_id',
              'filter' => false,
              'value'=> function($model){
                return isset($model->userReceive->name)? $model->userReceive->name : '';
              }
            ],
            // 'receipt_catch_no',
            [
               'attribute'=>'payment_method',
               'filter'=> Yii::$app->params['PayMethod'][Yii::$app->language],
               'value'=> function($model) {
                       return Yii::$app->params['PayMethod'][Yii::$app->language][$model->payment_method];
                   }
            ],
            [
               'attribute'=>'payment_status',
               'filter'=> Yii::$app->params['statusPayment2'][Yii::$app->language],
               'value'=> function($model) {
                       return Yii::$app->params['statusPayment2'][Yii::$app->language][$model->payment_status];
                   }
            ],
            'amount_paid',
            'amount_remaining',
            'details:ntext',
            'created_date:date',
            [
                'label' => yii::t('app','Receipt Catch Cancel'),
                'format' => 'raw',
                'contentOptions' => ['style' => 'text-align: center;'],
                'value'=> function($model) {
                    if($model->payment_status !== \common\models\Installment::STATUS_CANCEL){
                        return Html::a('<span class="fa fa-window-close-o" aria-hidden="true"></span>',
                            ['/installment-receipt-catch/cancel',
                                'id' => $model->id,
                            ],
                            ['data-pjax'=>"0",
                                'class' => 'btn btn-social-icon' ,
                                'data' => ['method' => 'post'],
                            ],
                        );
                    };
                    return '';
                },
                'visible' => yii::$app->user->can('/installment-receipt-catch/cancel'),
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}' ,
            ],
        ],
    ]); ?>

    </div>
</div>
