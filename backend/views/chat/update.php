<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Chat */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Chat',
]).$model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Chats'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="chat-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
