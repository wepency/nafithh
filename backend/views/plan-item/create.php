<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PlanItem */

$this->title = Yii::t('app', 'Create Plan Item');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Plan Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-item-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
