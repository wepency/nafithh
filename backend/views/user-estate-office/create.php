<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Owner */

$this->title = Yii::t('app', 'Create User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="owner-create">

    <?= $this->render('_form', [
    'model' => $model,
    'arrImages2' => $arrImages2,
    'permission' => $permission,
    ]) ?>

</div>
