<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\BankAccountOffice */

$this->title = Yii::t('app', 'Create Bank Account Office');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bank Account Offices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bank-account-office-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
