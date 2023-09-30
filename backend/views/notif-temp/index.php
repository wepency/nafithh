<?php

use yii\helpers\Html;

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\NotifTempSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Notif Temps');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notif-temp-index  box box-primary">


    <div class="box-body table-responsive"> 
      <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'name_en',
            'title_email:email',
            'title_email_en:email',
            //'body_email:ntext',
            //'body_email_en:ntext',
            //'body_sms:ntext',
            //'body_sms_en:ntext',
            //'enable_sms',
            //'enable_email:email',

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update}'
            ],
        ],
    ]); ?>

    </div>
</div>
