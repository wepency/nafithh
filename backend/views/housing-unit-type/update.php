<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\HousingUnitType */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Housing Unit Type',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Housing Unit Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="housing-unit-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
