<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ContractForm */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Contract Form',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contract Forms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="contract-form-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
