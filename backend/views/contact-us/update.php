<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ContactUs */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Contact Us',
]).$model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contact uses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="contact-us-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
