<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Plan */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Plans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="plan-view box box-primary">

    <div class="box-header">
        <?php if(yii::$app->user->can('/plan/update')){ ?>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php } ?> 
  

        <?php if(yii::$app->user->can('/plan/delete')){ ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        <?php } ?> 
    </div>

    <div class="box-body table-responsive">
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'id',
            'title',
            'title_en',
            [
                'format' => 'html',
                'attribute'=>'image',
                'value' => function ($model) {
                    return Html::img($model->image,['width' => '150px']);
                },
            ],
            'price',
            [
               'attribute'=>'status',
               'value'=> function($model) {
                    return Yii::$app->params['statusCase'][Yii::$app->language][$model->status];
                }
            ],
            [
               'attribute'=>'period',
               'filter'=> Yii::$app->params['period'][Yii::$app->language],
               'value'=> function($model) {
                    return Yii::$app->params['period'][Yii::$app->language][$model->period];
                }
            ],
            [
               'attribute'=>'currency',
               'filter'=> Yii::$app->params['currency'][Yii::$app->language],
               'value'=> function($model) {
                    return Yii::$app->params['currency'][Yii::$app->language][$model->currency];
                }
            ],
            [
                'attribute'=>yii::t('app','Count Features'),
                'value'=> function($model) {
                    return $model->getPlanItems()->count()?? 0;
                }
            ],
            [
                'label'=> yii::t('app','Count Orders'),
                'value'=> function($model) {
                    return $model->getOrders()->count()?? 0;
                }
            ],
            'created_date',
        ],
    ]) ?>
    </div>
</div>
