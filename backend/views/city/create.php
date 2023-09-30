<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\VolCity */

$this->title = Yii::t('app', 'Create City');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vol-city-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
