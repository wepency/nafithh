<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\OrderInfo */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Order Maintenance',
]).$model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Order Maintenances'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="order-info-update">

    <?= $this->render('_form', [
        'model' => $model,
        'arrImages2' => $arrImages2,
        'estateOfficeName' => $estateOfficeName,
        
    ]) ?>

</div>
