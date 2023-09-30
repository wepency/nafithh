<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Chat */

$this->title = Yii::t('app', 'Create Chat');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Chats'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chat-create">

    <?= $this->render('_form', [
        'modelhistory' => $modelhistory,
        'model' => $model,
    ]) ?>

</div>
