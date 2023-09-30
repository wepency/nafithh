<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ContractFormEstateOffice */

$this->title = Yii::t('app', 'Create Contract Form Estate Office');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contract Form Estate Offices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contract-form-estate-office-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
