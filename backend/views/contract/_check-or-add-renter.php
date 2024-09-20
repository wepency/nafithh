<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

use yii\helpers\ArrayHelper;

// use yii\widgets\Pjax;
// use yii\helpers\Url;
$Group = \common\components\GeneralHelpers::listUserAndOfficeByCurrent('renter');
$Group = ArrayHelper::map($Group,'id','id');
// $list = \common\models\User::find()->where(['or',['user_type'=>'renter'],['renter'=>1]])->all();
$list = \common\models\User::find()->where(['id' => $Group])->all();
$list = ArrayHelper::map($list,'identity_id','name');
/* @var $this yii\web\View */
/* @var $model common\models\BuildingHousingUnit */
/* @var $form yii\widgets\ActiveForm */
?>
<?php /*Pjax::begin([]);*/ ?>   

    <?php $form = ActiveForm::begin(['method' => 'get','action'=>['/contract/check-or-add-renter'],'options'=>['class'=>"form-horizontal form_check_renter"]]); ?>

    <div class="box-body table-responsive">
       <?php if(isset($owner) && !empty($owner)){ ?>
            <?=Yii::$app->view->renderFile('@backend/views/owner/_info-owner.php',['owner'=>$owner]);?>
            
        <?php } ?>
        <fieldset>
            <legend><?=Yii::t('app','Renter Information')?> :</legend>
            <div class='col-sm-12'>
                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Renters')?></label>
                <div class='col-sm-4'>
                    <?= Select2::widget([
                    'name' => "identity_id",
                    'id' => "identity_id1",
                    'data' => $list,
                    'options' => ['prompt'=>Yii::t('app','Select Renter')]
                    ])?>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="box-footer">
        <?= Html::button(Yii::t('app', 'Check or Add'), ['class' => 'btn btn-primary btn-flat loadMainContent']) ?>
    </div>
    <?php /*echo Html::button('Create New Company', ['value' => Url::to(['service/create']), 'title' => 'Viewing Company', 'class' => 'loadMainContent btn btn-success']);*/ ?>
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
