<?php

use yii\helpers\Html;
use yii\redactor\widgets\Redactor;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ChatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Chats');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chat-index  box box-primary">


    <div class="box-header with-border">
      <?= Html::a(Yii::t('app', 'Create Chat'), ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <?=Yii::$app->view->renderFile('@backend/views/layouts/_filter_date.php',['model'=>$searchModel,'label'=>yii::t('app','Created At')]);?>
    
    <div class="box-body table-responsive"> 
      <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model) {
            if($model->isHasNew()){
                return ['class' => 'success'];
            }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            // 'sender_id',
            'title',
            [
               'attribute'=>'sender_type',
                'filter'=> false,
               'value'=> function($model) {
                // print_r($model->getSender()); die();
                       return $model->getSender()["type"];
                   },
            ],
            [
               'attribute'=>'receiver_type',
                'filter'=> false,
               'value'=> function($model) {
                // print_r($model->getSender()); die();
                       return $model->getReceiver()["type"];
                   },
            ],
            // 'sender_type',
            // 'receiver_id',
            // 'receiver_type',
            'created_at:date',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}'
                ],
        ],
    ]); ?>

    </div>
</div>
