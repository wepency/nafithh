<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\BuildingHousingUnit;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;

// use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\BuildingHousingUnit */
/* @var $form yii\widgets\ActiveForm */
?>
<?php /*Pjax::begin([]);*/ ?>   

    <?php $form = ActiveForm::begin(['method' => 'get','action'=>['/contract/add-housing-unit'],'options'=>['class'=>"form_check_renter"]]); ?>

    <div class="box-body table-responsive">
        <?php if(isset($owner) && !empty($owner)){ ?>
            <?=Yii::$app->view->renderFile('@backend/views/owner/_info-owner.php',['owner'=>$owner]);?>
            
        <?php } ?>

        <?php if(isset($renter) && !empty($renter)){ ?>
            <?=Yii::$app->view->renderFile('@backend/views/renter/_info-renter.php',['renter'=>$renter]);?>

            
        <?php } ?>
        <fieldset>
            <legend><?=Yii::t('app','Housing Unit Information')?> :</legend>
            <div class='col-sm-12'>
                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Building') ?> </label> 
                <div class='col-sm-4'>
                    <?= $form->field($model, 'building_id')->widget(Select2::class, ['data' =>$buildings,'options' => ['prompt'=>Yii::t('app','Select Building')]])->label(false)?>
                </div>

                <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Housing Unit Name') ?></label> 
                <div class='col-sm-4'>
                    <?php
                    echo $form->field($model, "housing_unit_id")->widget(DepDrop::class, [
                        'data'=> ($model->isNewRecord ? [$model->building_id=>''] : BuildingHousingUnit::ListHousingByBuildingUnrented($model->building_id)),
                        'type'=> DepDrop::TYPE_SELECT2,
                        'pluginOptions'=>[
                            'depends'=>["contract-building_id"],
                            'initialize' => true,
                            'placeholder'=>Yii::t('app', 'Select Housing Unit'),
                            'url'=>Url::to(['/dropdown/housing-unrented']),
                            'loadingText' => Yii::t('app', 'Loading Housing Unit ...'),
                        ]
                    ])->label(false); ?> 
                                
                </div>
            </div>
        </fieldset>
        

    </div>
    <div class="box-footer">
        <?= Html::button(Yii::t('app', 'Next'), ['class' => 'btn btn-primary btn-flat loadMainContent']) ?>
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
