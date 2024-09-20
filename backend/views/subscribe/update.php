<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Subscribe */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Subscribe',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Subscribers Order'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="subscribe-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
