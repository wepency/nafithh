<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MaintenanceType */

$this->title = Yii::t('app', 'Create Maintenance Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Maintenance Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="maintenance-type-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
