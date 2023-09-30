<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PartnerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Partners');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partner-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a(Yii::t('app', 'Create Partner'), ['create'], ['class' => 'btn btn-success btn-flat']) ?>
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
                'title',
                'title_en',
                'url:url',
                //'image',
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
