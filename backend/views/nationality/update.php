<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Nationality */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Nationality',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Nationalities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="nationality-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
