<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\NotifTempEstateOffice */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Notif Temp Estate Office',
]).$model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Notif Temp Estate Offices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="notif-temp-estate-office-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
