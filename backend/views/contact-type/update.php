<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ContactType */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Contact Type',
]).$model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contact Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="contact-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
