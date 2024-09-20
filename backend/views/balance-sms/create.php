<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\BalanceSms */

$this->title = Yii::t('app', 'Create Balance Sms');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Balance Sms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="balance-sms-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
