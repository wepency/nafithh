<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Service */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-view box box-primary">
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
                'name',
                'name_en',
                [
                    'format' => 'html',
                    'attribute' =>'body',
                ],
                [
                    'format' => 'html',
                    'attribute' =>'body_en',
                ],
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
            ],
        ]) ?>
    </div>
</div>
