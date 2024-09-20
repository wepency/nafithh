<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Building */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Building',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Buildings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="building-update">

    <?= $this->render('_form', [
        'model' => $model,
        'arrImages2' => $arrImages2,
        'modelsHousings' => $modelsHousings,
    ]) ?>

</div>
