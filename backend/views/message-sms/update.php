<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MessageSms */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Message Sms',
]).$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Message Sms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="message-sms-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
