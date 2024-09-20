<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MaintenanceInvoice */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Maintenance Invoice',
]).$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Maintenance Invoices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="maintenance-invoice-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
