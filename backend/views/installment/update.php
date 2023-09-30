<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Installment */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Installment',
]).$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Installments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="installment-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
