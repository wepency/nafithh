<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\RentPeriod */

$this->title = Yii::t('app', 'Create Rent Period');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rent Periods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rent-period-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
