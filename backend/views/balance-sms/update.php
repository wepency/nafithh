<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BalanceSms */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Balance Sms',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Balance Sms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="balance-sms-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
