<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\HousingUnitType */

$this->title = Yii::t('app', 'Create Housing Unit Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Housing Unit Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="housing-unit-type-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
