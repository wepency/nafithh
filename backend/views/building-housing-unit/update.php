<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BuildingHousingUnit */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Building Housing Unit',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Building Housing Units'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="building-housing-unit-update">

    <?= $this->render('_form', [
        'arrImages2' => $arrImages2,
        'model' => $model,
    ]) ?>

</div>
