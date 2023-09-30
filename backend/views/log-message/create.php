<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LogMessage */

$this->title = Yii::t('app', 'Create Log Message');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Log Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-message-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
