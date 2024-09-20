<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\OrderInfo */

$this->title = Yii::t('app', 'Create Order Maintenance');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Order Maintenances'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-info-create">

    <?= $this->render('_form', [
        'arrImages2' => $arrImages2,
        'model' => $model,
        'estateOfficeName' => $estateOfficeName,
    ]) ?>

</div>
