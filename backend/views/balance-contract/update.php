<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BalanceContract */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Balance Contract',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Balance Contracts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="balance-contract-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
