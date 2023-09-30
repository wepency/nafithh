<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\BalanceContract */

$this->title = Yii::t('app', 'Create Balance Contract');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Balance Contracts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="balance-contract-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
