<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\IdentityType */

$this->title = Yii::t('app', 'Create Identity Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Identity Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="identity-type-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
