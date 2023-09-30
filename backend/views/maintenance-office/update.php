<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MaintenanceOffice */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Maintenance Office',
]).$model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Maintenance Offices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="maintenance-office-update">

    <?= $this->render('_form', [
		'arrImages2' => $arrImages2,
        'model' => $model,
    ]) ?>

</div>
