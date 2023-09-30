<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\HousingUsingType */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Housing Using Type',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Housing Using Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="housing-using-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
