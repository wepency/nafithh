<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\OrderMaintenance */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Order Maintenance',
]).$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Order Maintenances'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="order-maintenance-update">

    <?= $this->render('_form', [
        'model' => $model,
        'arrImages2' => $arrImages2,
        
    ]) ?>

</div>
