<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\InstallmentReceiptCatch */

$this->title = Yii::t('app', 'Create Installment Receipt Catch');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Installment Receipt Catches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="installment-receipt-catch-create">

    <?= $this->render('_form', [
        'model' => $model,
        'arrImages2' => $arrImages2,
        'estatOffice' => $estatOffice,
    ]) ?>

</div>
