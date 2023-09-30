<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\HousingUsingType */

$this->title = Yii::t('app', 'Create Housing Using Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Housing Using Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="housing-using-type-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
