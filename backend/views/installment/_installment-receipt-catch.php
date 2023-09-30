<?php

use yii\helpers\Html;
use yii\helpers\Url;

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\InstallmentReceiptCatchSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="box-body table-responsive"> 
      <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
      //   'filterRowOptions' =>[
      //   'enableSort'=> false,
      // ],
        'rowOptions' => function ($model) {
            if(!$model->user_receive_id){
                return ['class' => 'success'];
            }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'

          ],

            // 'id',
            // 'installment_id',
          [
            'attribute' =>'user_receive_id',
            'filter' => false,
            'value'=> function($model){
              return isset($model->userReceive->name)? $model->userReceive->name:'';
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
              'urlCreator' => function($action, $model, $key, $index) { 
                      return Url::to(['installment-receipt-catch/'.$action,'id'=>$key]);
              },
              'template' => (yii::$app->user->can('/installment-receipt-catch/update'))? '{view} {update}' :'{view} ' ,
            ],
        ],
    ]); ?>

</div>
