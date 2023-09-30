<?php

use yii\helpers\Html;

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\NotifTempEstateOfficeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Notif Temp Estate Offices');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notif-temp-estate-office-index  box box-primary">


    
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
            // 'title_email',
            // 'title_email_en',
            //'body_email:ntext',
            //'body_email_en:ntext',
            //'body_sms:ntext',
            //'body_sms_en:ntext',
            //'enable_sms',
            //'enable_email:email',
            //'estate_office_id',
            //'notification_id',

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update}'
            ],
        ],
    ]); ?>

    </div>
</div>
