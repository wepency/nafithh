<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\NotifTempEstateOffice */

$this->title = Yii::t('app', 'Create Notif Temp Estate Office');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Notif Temp Estate Offices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notif-temp-estate-office-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
