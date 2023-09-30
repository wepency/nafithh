<?php

use yii\helpers\Html;
use common\models\MaintenanceOffice;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderMaintenanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$controller = Yii::$app->controller->id;
if($controller != 'order-info'){
  $this->title = Yii::t('app', 'Order Maintenances');
  $this->params['breadcrumbs'][] = $this->title;
  
}
?>
<div class="order-maintenance-index  box box-primary">


   
    <div class="box-body table-responsive"> 
      <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

      <?=Yii::$app->view->renderFile('@backend/views/layouts/_filter_date.php',['model'=>$searchModel,'label'=>yii::t('app','Created Date')]);?>
      <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
               'attribute'=>'maintenance_office_id',
                'filter'=> ArrayHelper::map(MaintenanceOffice::find()->where(['>','id',0])->all(),'id','name'),
               'value'=> 'maintenanceOffice.name'
            ],
            // 'order_info_id',
            [
                'format' => 'html',
                'attribute' =>'note',
            ],
            'price',
             [
               'attribute'=>'status_accept',
               'filter'=> Yii::$app->params['yesNo'][Yii::$app->language],
               'value'=> function($model) {
                       return Yii::$app->params['yesNo'][Yii::$app->language][$model->status_accept];
                   }
            ],

            [
               'attribute'=>'orderInfo.sender_id',
                'value'=> function($model) {
                  return Yii::$app->params['userType'][Yii::$app->language][$model->orderInfo->sender_type].' - '.
                    $model->orderInfo->sender->name;
                }
            ],
            [
               'attribute'=>'orderInfo.created_date',
                'value'=> function($model) {
                  return $model->orderInfo->created_date;
                }
            ],
            [
               'attribute'=>'status',
               'filter'=> Yii::$app->params['statusOrder'][Yii::$app->language],
               'value'=> function($model) {
                       return yii::t('app',Yii::$app->params['statusOrder'][Yii::$app->language][$model->status]);
                   }
            ],
            [
               'attribute'=>'commission_amount',
                'visible' => yii::$app->user->can('/maintenance-invoice/create'/*,['building'=>$model->building]*/),

            ],
            [
               'attribute'=>'payment_at',
                'visible' => yii::$app->user->can('/maintenance-invoice/create'/*,['building'=>$model->building]*/),

            ],
            //'status',
            //'reason_disagree:ntext',

            ['class' => 'yii\grid\ActionColumn',
              'template' => '{update} {view}',
              'urlCreator' => function($action, $model, $key, $index) { 
                  return Url::to(['/order-maintenance/'.$action,'id'=>$key]);
                },
              'buttons' => [
                'update' => function ($url,$model,$key) {
                  return Html::a(
                    '<span class="glyphicon glyphicon-check"></span>', 
                    $url,['title' => Yii::t('app', "Replay")]);
                },
              ], 
            ],
        ],
    ]); ?>

    </div>
</div>
