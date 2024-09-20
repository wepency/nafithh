<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Owner */

$this->title = Yii::t('app', 'Create Owner');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Owners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="owner-create">
    <div class="owner-form box box-primary">

        <?=Yii::$app->view->renderFile('@backend/views/user/_checkExists.php',['userType'=>'owner']);?>
    </div>
    <?= $this->render('_form', [
    'model' => $model,
	'arrImages2' => $arrImages2,
    
    ]) ?>

</div>
