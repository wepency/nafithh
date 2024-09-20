<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\VolDistrict */

$this->title = Yii::t('app', 'Create District');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Districts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vol-district-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
