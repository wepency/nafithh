<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SystemIncome */

$this->title = Yii::t('app', 'Create System Income');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'System Incomes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-income-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
