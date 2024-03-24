<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\Plan;

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index  box box-primary">

    <?php /* if(yii::$app->user->can('/order/create')){ ?>
        <div class="box-header with-border">
          <?= Html::a(Yii::t('app', 'Create Order'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    <?php }*/ ?> 
    <div class="box-body table-responsive"> 
      <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model) {
            if($model->status == 0){
                return ['class' => 'success'];
            }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            //'content:ntext',
            'code',
            'mobile',
            'email:email',
            // 'company_name',
            //'plan_id',
            [
                'attribute' => 'plan_id',
                'format' => 'raw',
                'filter'=> ArrayHelper::map(Plan::find()->all(),'id','_title'),
                'value'=> function($model) {
                    return Html::a($model->plan->_title.'  &nbsp;'.Html::tag('i',null,['class'=>'fa fa-share-square-o']),Yii::$app->homeUrl.'plan/'.$model->plan->id,['style'=>'color:#3c8dbc!important;']);
                }
            ],
            [
               'attribute'=>'status',
               'filter'=> Yii::$app->params['statusRead'][Yii::$app->language],
               'value'=> function($model) {
                    return Yii::$app->params['statusRead'][Yii::$app->language][$model->status];
                }
            ],
            // [
            //    'attribute'=>'payment_status',
            //    'filter'=> Yii::$app->params['statusPayment'][Yii::$app->language],
            //    'value'=> function($model) {
            //         return Yii::$app->params['statusPayment'][Yii::$app->language][$model->payment_status];
            //     }
            // ],
            //  [
            //    'attribute'=>'company_type',
            //    'filter'=> Yii::$app->params['company_type'][Yii::$app->language],
            //    'value'=> function($model) {
            //         return Yii::$app->params['company_type'][Yii::$app->language][$model->company_type];
            //     }
            // ],
            'created_date',
            [
               'attribute'=>'response_by',
               'filter'=> false,
               'value'=> function($model) {
                    return $model->responseBy?->name;
                }
            ],
            // 'responseBy.name',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => yii::$app->user->can('/order/delete')? '{view} {delete} ' : (yii::$app->user->can('/order/update')? '{view}' : (yii::$app->user->can('/order/view')? '{view}' : ''))
            ],
        ],
    ]); ?>

    </div>
</div>
