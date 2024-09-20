<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Owner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="owner-form box box-primary">
    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>
    <div class="box-body table-responsive">
        <fieldset>
            <div class='col-sm-12'>
                <?=Yii::$app->view->renderFile('@backend/views/user/_form-any-user.php',['arrImages2' => $arrImages2,'model'=>$model,'form'=>$form]);?>
            </div>
        </fieldset>
        <?=Yii::$app->view->renderFile('@backend/views/user/permissionUser.php',['model' => $model,'permission'=>$permission,'form'=>$form]);?>
    </div>

	<?php if (!Yii::$app->request->isAjax){ ?>

    <div class="box-footer">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-flat']) ?>
    </div>
	<?php } ?>
    <?php ActiveForm::end(); ?>
</div>
