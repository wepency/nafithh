<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\VolDistrict */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'District',
]).$model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Districts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="vol-district-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
