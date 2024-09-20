<?php

use yii\helpers\Html;

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\NotificationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Notifications');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notification-index  box box-primary">


    <div class="box-body table-responsive"> 
      <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model) {
            if($model->status_read == 0){
                return ['class' => 'success'];
            }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            // 'notification_type',
            // 'receiver_id',
            // 'receiver_type',
            [
                'format' => 'html',
                'attribute' =>'content',
            ],
            // 'content',
            [
                'attribute'=>'status_read',
                'filter'=> Yii::$app->params['statusRead'][Yii::$app->language],
                'value'=> function($model) {
                       return Yii::$app->params['statusRead'][Yii::$app->language][$model->status_read];
                          }
            ],
            //'subject_id',
            //'table_name',
            'created_at',
            // 'readed_at',
            //'status_read',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}{delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                    'title' => Yii::t('app', 'lead-view'),
                        ]);
                    },
                ]
            ],
        ],
    ]); ?>

    </div>
</div>
