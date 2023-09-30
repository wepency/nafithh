<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BankAccountOffice */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Bank Account Office',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bank Account Offices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="bank-account-office-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
