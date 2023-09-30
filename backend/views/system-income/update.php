<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SystemIncome */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'System Income',
]).$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'System Incomes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="system-income-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
