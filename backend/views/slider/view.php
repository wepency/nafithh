<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Slider */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sliders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-view box box-primary">
    <div class="box-header">
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'title',
                'title_en',
                [
                    'format' => 'html',
                    'attribute' =>'text',
                ],
                [
                    'format' => 'html',
                    'attribute' =>'text_en',
                ],
                'url:url',
                [
			  
				'format' => 'html',
				'label' => yii::t('app','Image Or Video'),
				'attribute'=>'image',
				'value' => function ($model) {
				 
						$pathImage = $model->image;
						
					   return Html::img($pathImage,['width' => '400px']);
					 
				},
				
				],
                [
				   'attribute'=>'status',
				   'label'=>yii::t('app','Status'),
				   'value'=> function($model) {
						   return Yii::$app->params['statusCase'][Yii::$app->language][$model->status];
					   }
				], 
            ],
        ]) ?>
    </div>
</div>
