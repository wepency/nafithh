<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ContractForm */

$this->title = Yii::t('app', 'Create Contract Form');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contract Forms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contract-form-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
