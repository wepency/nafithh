 <?php 
 $EOS = yii::$app->SiteSetting->queryEOS();
 use yii\helpers\ArrayHelper;
use common\models\IdentityType;
use common\models\Nationality;
use kartik\select2\Select2;
use yii\redactor\widgets\Redactor;

?>
        <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'name')?></label>
        <div class='col-sm-4'>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(false) ?>
        </div>

        <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Username') ?> </label> 
        <?php 
         if ($model->isNewRecord){
            $attrs = ['maxlength' => true];
         }else
            $attrs = ['maxlength' => true,'disabled'=>true];
            
        ?>
        <div class='col-sm-4'><?= $form->field($model, 'username')->textInput($attrs)->label(false) ?></div>
        <div class="clearfix"></div>

        <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Identity Id')?></label>
        <div class='col-sm-4'>
        <?= $form->field($model, 'identity_id')->textInput(['maxlength' => true])->label(false) ?>
        </div>

        <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Identity Type')?></label>
        <div class='col-sm-4'>
            <?= $form->field($model, 'identity_type_id')->widget(Select2::class, ['data' =>ArrayHelper::map($EOS['identities']->all(),'id','_name'),'options' => ['prompt'=>Yii::t('app','Select Identity Type')]])->label(false)?>
        </div>
        <div class="clearfix"></div>

        <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Password') ?> </label> 
        <div class='col-sm-4'><?= $form->field($model, 'password')->textInput(['maxlength' => true])->label(false) ?></div>

        <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'mobile')?></label>
        <div class='col-sm-4'>
        <?= $form->field($model, 'mobile')->textInput(['maxlength' => true])->label(false) ?>
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
        <div class="clearfix"></div>

        <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Nationality')?></label>
        <div class='col-sm-4'>
        <?= $form->field($model, 'nationality_id')->widget(Select2::class, ['data' =>ArrayHelper::map($EOS['nationalities']->all(),'id','_name'),'options' => ['prompt'=>Yii::t('app','Select Nationality')]])->label(false)?>
        </div>
        <div class="clearfix"></div>
        <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Other Notes')?></label>
        <div class='col-sm-10'><?= $form->field($model, 'description')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                            'lang' => Yii::$app->language,
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
                            
        </div>

        <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Attachments') ?> </label> 
        <div class='col-sm-10'>
            <?= \common\components\MultiAttachmentWidget::widget(['model'=>$model,'form'=>$form,'files'=>$arrImages2])?>
        </div>


        