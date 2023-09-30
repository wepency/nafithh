<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MaintenanceOffice */

$this->title = Yii::t('app', 'Create Maintenance Office');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Maintenance Offices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="maintenance-office-create">

    <?= $this->render('_form', [
		'arrImages2' => $arrImages2,
        'model' => $model,
    ]) ?>

</div>
