<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Renter */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Renter',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Renters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="renter-update">

    <?= $this->render('_form', [
        'model' => $model,
        'arrImages2' => $arrImages2,
        'modelRenter' => $modelRenter,

    ]) ?>

</div>
