<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SmsProvider */

$this->title = Yii::t('app', 'Create Sms Provider');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sms Providers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sms-provider-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
