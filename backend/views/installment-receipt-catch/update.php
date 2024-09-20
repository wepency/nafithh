<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\InstallmentReceiptCatch */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Installment Receipt Catch',
]).$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Installment Receipt Catches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="installment-receipt-catch-update">

    <?= $this->render('_form', [
        'model' => $model,
        'arrImages2' => $arrImages2,
        'estatOffice' => $estatOffice,
    ]) ?>

</div>
