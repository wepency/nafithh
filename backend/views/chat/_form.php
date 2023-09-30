<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use common\models\Chat;
use kartik\select2\Select2;
use yii\redactor\widgets\Redactor;

/* @var $this yii\web\View */
/* @var $model common\models\Chat */
/* @var $form yii\widgets\ActiveForm */
  // // $senderTo = ['maintenance_officer' => Yii::t('app', 'Maintenance Office')
  //           ,'estate_officer' => Yii::t('app', 'Estate Office')
  //           ]; 


?>

<div class="chat-form box box-primary">

    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>

     <div class="box-body table-responsive">
		<fieldset>
            <div class='col-sm-12'>
				
                <div class='clearfix'></div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Receiver Type')?></label>
                <div class='col-sm-4'>
                    <?= $form->field($model, 'receiver_type')->widget(Select2::class, ['data' =>Chat::listReceivers(),'options' => ['prompt'=>Yii::t('app','Receiver Type')]])->label(false)?>
                </div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Receiver')?></label>
                <div class='col-sm-4'>
                    <?php
                    echo $form->field($model, "receiver_id")->widget(DepDrop::class, [
                    
                        'data'=> [$model->receiver_type=>''],
                        'type'=> DepDrop::TYPE_SELECT2,
                        
                        'pluginOptions'=>[
                            'depends'=>["chat-receiver_type"],
                            'initialize' => true,
                            'placeholder'=>Yii::t('app', 'Select Receiver'),
                            'url'=>Url::to(['/dropdown/chatSendTo']),
                            'loadingText' => Yii::t('app', 'Loading Receiver ...'),
                        ]
                        ])->label(false); ?> 
                                
                </div>

                <div class='clearfix'></div>

                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Title')?></label>
                <div class='col-sm-10'>
                <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label(false) ?>
                </div>
                
                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Message')?></label>
                <div class='col-sm-10'><?= $form->field($modelhistory, 'message')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                            'lang' => Yii::$app->language,
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
                            
                </div>

                <div class='clearfix'></div>

			</div>
		</fieldset>
	</div>
	
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Send') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
