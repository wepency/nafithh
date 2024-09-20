<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$Group = \common\components\GeneralHelpers::listUserAndOfficeByCurrent('owner');
$Group = ArrayHelper::map($Group,'id','id');
$list = \common\models\User::find()->where(['id' => $Group])->all();
// $list = \common\models\User::find()->where(['or',['user_type'=>'owner'],['owner'=>1]])->all();
$list = ArrayHelper::map($list,'identity_id','name');



// use yii\widgets\Pjax;
// use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\BuildingHousingUnit */
/* @var $form yii\widgets\ActiveForm */
?>
<?php /*Pjax::begin([]);*/ ?>   

    <?php $form = ActiveForm::begin(['method' => 'get','action'=>['/contract/check-or-add'],'options'=>['class'=>"form-horizontal form_check_owner"]]); ?>

    <div class="box-body table-responsive">
        <fieldset>
            <legend><?=Yii::t('app','Owner Information')?> :</legend>
            <div class='col-sm-12'>
                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Owners')?></label>

                <div class='col-sm-4'>
                    <?=  Select2::widget([
                    'name' => "identity_id",
                    'id' => "identity_id",
                    'data' => $list,
                    'options' => ['prompt'=>Yii::t('app','Select Owner')]
                    ])?>
                </div>
            </div>
        </fieldset>

    </div>
    <div class="box-footer">

        <?= Html::button(Yii::t('app', 'Check or Add'), ['class' => 'btn btn-primary btn-flat loadMainContent']) ?>
    </div>
    <?php ActiveForm::end(); ?>
 <?php /*Pjax::end();*/ ?>
 
<?php 
$script = <<< JS
$(document).ready(function(){
checkOrAdd();
});
JS;
$this->registerJs($script);
?>
