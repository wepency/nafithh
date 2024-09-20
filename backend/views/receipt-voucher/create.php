<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ReceiptVoucher */

$this->title = Yii::t('app', 'Create Receipt Voucher');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Receipt Vouchers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="receipt-voucher-create">
    <div class="box-header with-border">
    <label class="label-primary label">
        <?=yii::t('app','To approve the owners exchange voucher within the owners account statement, the voucher must be added from the account statement section'); ?>
    </label>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
        'arrImages2' => $arrImages2,
        'estatOffice' => $estatOffice,
        'estateHousing' => $estateHousing,
    ]) ?>

</div>
