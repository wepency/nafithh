<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SystemIncome */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'System Incomes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="system-income-view box box-primary">

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
            'item',
            'amount',
            [
                'format' => 'html',
                'attribute' =>'details',
            ],
            [
              'attribute' =>'user_created_id',
              'value'=> function($model){
                return $model->userCreated->name;
              }
            ],
            'created_date',
            'pay_date',
        ],
    ]) ?>
    </div>
</div>
