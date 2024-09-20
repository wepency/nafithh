<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SmsProvider */


$this->title = Yii::t('app', 'Email and SMS Provider Settings');


$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'SMS Provider')];

?>
<div class="sms-provider-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
