<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Subscribe */

$this->title = Yii::t('app', 'Create Subscribe');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Subscribers Order'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscribe-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
