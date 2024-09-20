<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\NotifTemp */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Notif Temp',
]).$model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Notif Temps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="notif-temp-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
