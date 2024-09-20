<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\OrderMaintenance */

$this->title = Yii::t('app', 'Create Order Maintenance');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Order Maintenances'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-maintenance-create">

    <?= $this->render('_form', [
        'model' => $model,
        'arrImages2' => $arrImages2,
        
    ]) ?>

</div>
