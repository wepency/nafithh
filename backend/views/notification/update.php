<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Notification */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Notification',
]).$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Notifications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="notification-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
