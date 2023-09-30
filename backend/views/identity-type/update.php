<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\IdentityType */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Identity Type',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Identity Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="identity-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
