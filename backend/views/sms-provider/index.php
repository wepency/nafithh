<?php

use yii\helpers\Html;

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SmsProviderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Sms Providers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sms-provider-index  box box-primary">


    <div class="box-header with-border">
    </div>
    <div class="box-body table-responsive"> 
      <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'domain',
            'username',
            'password',
            'sender',
            //'sendgrid_username',
            //'sendgrid_password',
            //'paypal_type',
            //'sandbox',
            //'production',
            //'sending_status',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
