<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'User',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name];

?>
<div class="user-update">


    <?= $this->render('_form', [
        'model' => $model,
        'arrImages2' => $arrImages2,
        'permission' => $permission,
        
    ]) ?>

</div>
