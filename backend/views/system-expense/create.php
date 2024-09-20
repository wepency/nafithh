<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SystemExpense */

$this->title = Yii::t('app', 'Create System Expense');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'System Expenses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-expense-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
