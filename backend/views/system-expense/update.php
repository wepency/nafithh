<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SystemExpense */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'System Expense',
]).$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'System Expenses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="system-expense-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
