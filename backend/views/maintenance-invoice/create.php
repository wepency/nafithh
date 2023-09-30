<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MaintenanceInvoice */

$this->title = Yii::t('app', 'Create Maintenance Invoice');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Maintenance Invoices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="maintenance-invoice-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
