<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ContractFormEstateOffice */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Contract Form Estate Office',
]).$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contract Form Estate Offices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="contract-form-estate-office-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
