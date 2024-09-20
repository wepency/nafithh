<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Installment */

$this->title = Yii::t('app', 'Create Installment');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Installments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="installment-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
