<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\EstateOffice */

$this->title = Yii::t('app', 'Create Estate Office');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Estate Offices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estate-office-create">

    <?= $this->render('_form', [
    'model' => $model,
	'arrImages2' => $arrImages2,
    ]) ?>

</div>
