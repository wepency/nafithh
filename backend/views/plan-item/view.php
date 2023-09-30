<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\PlanItem */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Plan Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="plan-item-view box box-primary">

    <div class="box-header">
        <?php if(yii::$app->user->can('/plan-item/update')){ ?>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php } ?> 
  

        <?php if(yii::$app->user->can('/plan-item/delete')){ ?>
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
                'attribute' => 'plan_id',
                'value' => 'plan._title'
            ],
            'plan._title',
            'sort_at',
        ],
    ]) ?>
    </div>
</div>
