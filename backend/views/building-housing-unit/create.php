<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\BuildingHousingUnit */

$this->title = Yii::t('app', 'Create Building Housing Unit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Building Housing Units'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="building-housing-unit-create">

    <?= $this->render('_form', [
    'arrImages2' => $arrImages2,
    'model' => $model,
    ]) ?>

</div>
