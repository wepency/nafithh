<?php

use yii\helpers\Html;

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Banners');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-index  box box-primary">


    <div class="box-header with-border">
      <?= Html::a(Yii::t('app', 'Create Banner'), ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="box-body table-responsive"> 
      <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            // 'title_en',
            // 'text:ntext',
            // 'text_en:ntext',
            //'url:url',
            [
              
                'format' => 'html',
                'label' => yii::t('app','Image'),
                'attribute'=>'image',
                'value' => function ($model) {
                       return Html::img($model->image,['width' => '150px']);
                },
                
            ],
            [
               'attribute'=>'status',
               'label'=>yii::t('app','Status'),
               'value'=> function($model) {
                       return Yii::$app->params['statusCase'][Yii::$app->language][$model->status];
                   }
            ], 

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
