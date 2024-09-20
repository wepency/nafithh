<?php

use yii\helpers\Html;

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\LogMessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Log Messages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-message-index  box box-primary">


    <div class="box-header with-border">
      <?= Html::a(Yii::t('app', 'Create Log Message'), ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="box-body table-responsive"> 
      <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'sender_id',
            'sender_type',
            'notif_temp_id',
            'receiver_id',
            'receiver_type',
            'contact_mobile',
            'contact_email:email',
            [
            'format' => 'html',
            'attribute' =>'message',
            ],
            // 'message:ntext',
            'status',
            'created_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
