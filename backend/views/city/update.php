<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\VolCity */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'City',
]).$model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vol Cities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="vol-city-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
