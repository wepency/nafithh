<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PlanItem */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Plan Item',
]).$model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Plan Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="plan-item-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
