<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RentPeriod */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Rent Period',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rent Periods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="rent-period-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
