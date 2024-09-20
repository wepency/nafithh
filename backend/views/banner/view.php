<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Banner */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Banners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="banner-view box box-primary">

    <div class="box-header">
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <div class="box-body table-responsive">
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'id',
            'title',
            // 'title_en',
            // 'text:ntext',
            // 'text_en:ntext',
            'url:url',
            [
          
                'format' => 'html',
                'label' => yii::t('app','Image'),
                'attribute'=>'image',
                'value' => function ($model) {
                       return Html::img($model->image,['width' => '400px']);
                     
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
