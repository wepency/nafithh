<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Renter */

$this->title = Yii::t('app', 'Create Renter');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Renters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="renter-create">
    
    <div class="box box-primary">

        <?=Yii::$app->view->renderFile('@backend/views/user/_checkExists.php',['userType'=>'renter']);?>
    </div>
    <?= $this->render('_form', [
    'model' => $model,
    'arrImages2' => $arrImages2,
    'modelRenter' => $modelRenter,
    ]) ?>

</div>
