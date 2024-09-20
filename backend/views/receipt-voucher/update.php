<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ReceiptVoucher */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Receipt Voucher',
]).$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Receipt Vouchers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="receipt-voucher-update">

    <?= $this->render('_form', [
        'model' => $model,
        'arrImages2' => $arrImages2,
        'estatOffice' => $estatOffice,
    ]) ?>

</div>
