<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Services');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-index box box-primary">
    <?php Pjax::begin(); ?>
    <div class="box-header with-border">
        <?= Html::a(Yii::t('app', 'Create Service'), ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <div class="box-body table-responsive">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{summary}\n{items}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'name',
                'name_en',
                /* 'body:ntext',
                'body_en:ntext', */
				[
			  
				'format' => 'html',
				'label' => yii::t('app','Image'),
				'attribute'=>'image',
				'value' => function ($model) {
				  
						$width = 200; $height = 200;
						$pathImage = $model->image;
						
					   return Html::img($pathImage);
					 
				},
				
				],
                [
                   'attribute'=>'status',
                   'filter'=> Yii::$app->params['statusCase'][Yii::$app->language],
                   'label'=>yii::t('app','Status'),
                   'value'=> function($model) {
                           return Yii::$app->params['statusCase'][Yii::$app->language][$model->status];
                       }
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>
</div>
