<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ContactUsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contact uses');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-us-index  box box-primary">

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
            'email:email',
            'mobile',
            'title',
            //'msg:ntext',
            'created_at',
            //'replay_msg:ntext',
            //'user_id',
            [
               'attribute'=>'status',
               'filter'=> Yii::$app->params['statusRead'][Yii::$app->language],
               'value'=> function($model) {
                    return Yii::$app->params['statusRead'][Yii::$app->language][$model->status];
                }
            ],
            [
                'attribute'=>'contact_type_id',
                'filter'=> ArrayHelper::map(\common\models\ContactType::find()->all(),'id','_title'),
                'value'=> function($model) {
                    return $model->contactType->_title;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => yii::$app->user->can('/contact-us/delete')? '{view} {delete} ' : (yii::$app->user->can('/contact-us/view')? '{view}' : '')
            ],
        ],
    ]); ?>

    </div>
</div>
