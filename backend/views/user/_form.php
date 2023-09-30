<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\file\FileInput;
use common\models\IdentityType;
use common\models\Nationality;
use kartik\select2\Select2;
use yii\redactor\widgets\Redactor;

?>


<!------------>
<div class="renter-form box box-primary">
    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>
    <div class="box-body table-responsive">
        <fieldset>
        	<div class="row">
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'User Type available') ?> </label> 
                <?php 
                 foreach (\common\components\MultiUserType::availableUserType($model->id) as $key => $value) { 
                    // print_r($model->getListPaymentMethod()); die(); ?>
                <div class='col-sm-2'>
                    <?php $model->isNewRecord ? $model->{$key} = 0 : $model->{$key};?>
                    <?= $form->field($model, $key)->radioList(Yii::$app->params['yesNo'][Yii::$app->language])->label(Yii::$app->params['userType'][Yii::$app->language][$key]) ?>
                </div>
                <?php } ?>
            </div>
            <div class="clearfix"></div>
			<div class='col-sm-12'>
				<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'name')?></label>
				<div class='col-sm-4'>
				<?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(false) ?>
				</div>
				
				<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'mobile')?></label>
				<div class='col-sm-4'>
				<?= $form->field($model, 'mobile')->textInput(['maxlength' => true])->label(false) ?>
				</div>
				<div class="clearfix"></div>


				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Username') ?> </label> 
				<div class='col-sm-4'>
				<?php if ($model->isNewRecord){
					echo $form->field($model, 'username')->textInput(['maxlength' => true])->label(false);
				?>
				 <?php }else{ ?>
				      <label class='label-data'><?= $model->username ?></label>
				<?php } ?>
				</div>

				<label for='' class='col-sm-2 control-label'><?=Yii::t('app','User Type')?></label>

				<div class='col-sm-4'>
					<?php if(yii::$app->user->identity->user_type === "developer"){ ?>

						<?= $form->field($model, 'user_type')->widget(Select2::class, ['data' =>Yii::$app->params['userType'][Yii::$app->language],'options' => ['prompt'=>Yii::t('app','Select User Type'),'class'=>' form-control login_form']])->label(false) ?>
					<?php } else { ?>
					    <label class='label-data'><?= yii::t('app',"$model->user_type") ?></label>
					<?php } ?>
				</div>
				<div class="clearfix"></div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Password') ?> </label> 
				<div class='col-sm-4'>
				<?= $form->field($model, 'password')->textInput(['type'=>'password','class'=>' form-control login_form'])->label(false) ?>
				</div>

				<label for='' class='col-sm-2 control-label'><?= Yii::t('app','Confirm Password') ?> </label> 
				<div class='col-sm-4'>
				  <?= $form->field($model, 'newPasswordConfirm')->textInput(['type'=> 'password','class'=>' form-control login_form'])->label(false) ?>
				</div>
				<div class="clearfix"></div>


				<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'email')?></label>
				<div class='col-sm-4'>
				<?= $form->field($model, 'email')->textInput(['maxlength' => true])->label(false) ?>
				</div>
                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'address')?></label>
				<div class='col-sm-4'>
				<?= $form->field($model, 'address')->textInput(['maxlength' => true])->label(false) ?>
				</div>
				<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'identity_id')?></label>
				<div class='col-sm-4'>
				<?= $form->field($model, 'identity_id')->textInput(['maxlength' => true])->label(false) ?>
				</div>

				<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'identity_type_id')?></label>
				<div class='col-sm-4'>
					<?= $form->field($model, 'identity_type_id')->widget(Select2::class, ['data' =>ArrayHelper::map(IdentityType::find()->all(),'id','_name'),'options' => ['prompt'=>Yii::t('app','Select Identity Type')]])->label(false)?>
				</div>
				<div class="clearfix"></div>
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Fav Lang') ?> </label> 
				<div class='col-sm-4'>
					<?php $model->isNewRecord ? $model->fav_lang='ar':$model->fav_lang;?>
					<?= $form->field($model, 'fav_lang')->radioList(Yii::$app->params['langauges'][Yii::$app->language])->label(false) ?>
				</div>
				
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Status Account') ?> </label> 
				<div class='col-sm-4'>
					<?php $model->isNewRecord ? $model->status=10:$model->status;?>
					<?= $form->field($model, 'status')->radioList(Yii::$app->params['statusAccount'][Yii::$app->language])->label(false) ?>
				</div>

				
				<div class="clearfix"></div>

				<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Nationality')?></label>
		        <div class='col-sm-4'>
		        	<?= $form->field($model, 'nationality_id')->widget(Select2::class, ['data' =>ArrayHelper::map(Nationality::find()->all(),'id','_name'),'options' => ['prompt'=>Yii::t('app','Select Nationality')]])->label(false)?>
		        </div>
		        <div class="clearfix"></div>

				<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'avatar')?></label>
				<div class='col-sm-10'>
					<?php
						echo $form->field($model, 'avatar')->widget(FileInput::class, [
							'options' => ['accept' => 'image/*'],
							'pluginOptions' => [
									'allowedPreviewTypes' => ['image'],
									'previewFileType' => 'any',
									'showUpload' => false,
									'showRemove' => true,
									'initialPreview'=> !empty($model->avatar) ? Yii::$app->uploadUrl->baseUrl."/user/".$model->avatar : '',
									'initialPreviewAsData'=>true,
									'deleteUrl' => Url::to(['user/delete-file', 'id' => $model->id,'avatar']),
							],
						])->label(false);  ?>
				</div>
				<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Attachments') ?> </label> 
		        <div class='col-sm-10'>
		            <?= \common\components\MultiAttachmentWidget::widget(['model'=>$model,'form'=>$form,'files'=>$arrImages2])?>
		        </div>

				<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'description')?></label>
				<div class='col-sm-10'>
				<?= $form->field($model, 'description')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                            'lang' => Yii::$app->language,
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
				</div>


				
				<div class="clearfix"></div>

				<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'black_list')?></label>
				<div class='col-sm-4'>
					<?php $model->isNewRecord ? $model->black_list=0:$model->black_list;?>
					<?= $form->field($model, 'black_list')->radioList(Yii::$app->params['yesNo'][Yii::$app->language])->label(false) ?>
				</div>
	        
		   
		   
		   
	   	        <?php echo $form->field($model, 'activation_code')->hiddenInput(['value'=> '1'])->label(false); ?>
		
		    </div>
	    </fieldset>
	    <?php if($model->isNewRecord || $model->user_type === 'admin_user'){ ?>
	    <?=Yii::$app->view->renderFile('@backend/views/user/permissionUser.php',['model' => $model,'permission'=>$permission,'form'=>$form]);?>	
	    <?php } ?>	
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>



