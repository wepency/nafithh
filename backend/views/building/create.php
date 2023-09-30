<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Building */

$this->title = Yii::t('app', 'Create Building');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Buildings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="building-create">

    <?= $this->render('_form', [
    'model' => $model,
    'arrImages2' => $arrImages2,
    'modelsHousings' => $modelsHousings,
    ]) ?>

</div>
