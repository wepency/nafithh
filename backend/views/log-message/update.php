<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LogMessage */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Log Message',
]).$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Log Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="log-message-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
