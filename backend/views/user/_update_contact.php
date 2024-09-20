<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\file\FileInput;
use common\models\IdentityType;
use kartik\select2\Select2;

use common\models\Nationality;

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'User',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name];
?>


<!------------>
<div class="renter-form box box-primary">
    <?php $form = ActiveForm::begin(['options'=>['class'=>""]]); ?>
    <div class="box-body table-responsive">

        <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Full name')?></label>
        <div class='col-sm-4'>
        	<?= $model->name ?>
        </div>

        <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Username') ?> </label> 
        <div class='col-sm-4 form-group'>
            <label class='label-data'><?= $model->username ?></label>
        </div>
        <div class="clearfix"></div>

        <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Identity Type') ?> </label> 
        <div class='col-sm-4 form-group'>
            <label class='label-data'><?= ($model->identityType) ?$model->identityType->_name:'' ?></label>
        </div>

        <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Identity Id') ?> </label> 
        <div class='col-sm-4 form-group'>
            <label class='label-data'><?= $model->identity_id ?></label>
        </div>
        <div class="clearfix"></div>

        <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'mobile') ?> </label> 
        <div class='col-sm-4 form-group'>
            <?= $form->field($model, 'mobile')->textInput(['maxlength' => true])->label(false) ?>
        </div>

        <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Email') ?> </label> 
        <div class='col-sm-4 form-group'>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label(false) ?>
        </div>
        <div class="clearfix"></div>

        <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Nationality') ?> </label> 
        <div class='col-sm-4 form-group'>
            <?= $form->field($model, 'nationality_id')->widget(Select2::class, ['data' =>ArrayHelper::map(Nationality::find()->all(),'id','_name'),'options' => ['prompt'=>Yii::t('app','Select Nationality')]])->label(false)?>
        </div>
        <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'address')?></label>
        <div class='col-sm-4'>
        <?= $form->field($model, 'address')->textInput(['maxlength' => true])->label(false) ?>
        </div>
     

    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>



