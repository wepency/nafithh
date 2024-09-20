<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Owner */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Owner',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Owners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="owner-update">

    <?= $this->render('_form', [
        'model' => $model,
		'arrImages2' => $arrImages2,
        
    ]) ?>

</div>
