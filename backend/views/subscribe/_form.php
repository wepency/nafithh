<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor;
/* @var $this yii\web\View */
/* @var $model common\models\Subscribe */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subscribe-form box box-primary">
    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>
    <div class="box-body table-responsive">
        <fieldset>
            <div class='col-sm-12'>
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Name') ?> </label> 

                <div class='col-sm-10'><?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(false) ?></div>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Email') ?> </label>

                <div class='col-sm-10'><?= $form->field($model, 'email')->textInput(['maxlength' => true])->label(false) ?></div>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Mobile') ?> </label> 

                <div class='col-sm-10'><?= $form->field($model, 'mobile')->textInput(['maxlength' => true])->label(false) ?></div>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Company Type') ?> </label> 

                <div class='col-sm-10'><?= $form->field($model, 'compony_type')->textInput()->label(false) ?></div>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Company Name') ?> </label> 

                <div class='col-sm-10'><?= $form->field($model, 'compony_name')->textInput(['maxlength' => true])->label(false) ?></div>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Message') ?> </label> 

                <div class='col-sm-10'><?= $form->field($model, 'message')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                            'lang' => Yii::$app->language,
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']
                         ]
                        ])->label(false)?>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="box-footer">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
