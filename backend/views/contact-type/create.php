<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ContactType */

$this->title = Yii::t('app', 'Create Contact Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contact Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
