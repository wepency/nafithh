<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MessageSms */

$this->title = Yii::t('app', 'Create Message Sms');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Message Sms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-sms-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
