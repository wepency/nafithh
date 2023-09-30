<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\NotifTemp */

$this->title = Yii::t('app', 'Create Notif Temp');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Notif Temps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notif-temp-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
