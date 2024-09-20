<?php

use yii\helpers\Html;
use yii\redactor\widgets\Redactor;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\MessageSmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Message Sms');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-sms-index  box box-primary">


    <div class="box-header with-border">
      <?= Html::a(Yii::t('app', 'Create Message Sms'), ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <?=Yii::$app->view->renderFile('@backend/views/layouts/_filter_date.php',['model'=>$searchModel,'label'=>yii::t('app','Created Date')]);?>
    <div class="box-body table-responsive"> 
      <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            
            'message',
            'numbers:ntext',
            [
              'attribute' =>'user_created_id',
              'filter' => false,
              'value'=> function($model){
                return $model->userCreated->name;
              }
            ],
            'created_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
