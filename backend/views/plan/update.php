<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Plan */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Plan',
]).$model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Plans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="plan-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelsPlanItem' => $modelsPlanItem,
    ]) ?>

</div>
