<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
// use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\BuildingHousingUnit */
/* @var $form yii\widgets\ActiveForm */
?>
<?php /*Pjax::begin([]);*/ ?>   

    
<?php
// print_r( "[{$i}]"); die();
    // necessary for update action.
     
?>
    <div class="box-body table-responsive">
        <?php if(isset($owner) && !empty($owner)){ ?>
            <?=Yii::$app->view->renderFile('@backend/views/owner/_info-owner.php',['owner'=>$owner]);?>
            
        <?php } ?>

        <?php if(isset($renter) && !empty($renter)){ ?>
            <?=Yii::$app->view->renderFile('@backend/views/renter/_info-renter.php',['renter'=>$renter]);?>

            
        <?php } ?>

        <?php if(isset($housingUnit) && !empty($housingUnit)){ ?>

            <?=Yii::$app->view->renderFile('@backend/views/building-housing-unit/_info-housing.php',['housingUnit'=>$housingUnit]);?>
            
        <?php } ?>
    
    <?php Pjax::begin(); ?>
        <?php $form = ActiveForm::begin(['method' => 'post','action'=>['/contract/add-contract'],'options'=>['class'=>" form_add_contract",'data' => ['pjax' => true] ]]); ?>
        <fieldset>
            <legend><?=Yii::t('app','Contract Information')?> :</legend>
            <div class='col-sm-12'>
                
                <?=Yii::$app->view->renderFile('@backend/views/contract/_form.php',['model'=>$model,'form'=>$form,'arrImages2'=>$arrImages2]);?>

            </div>
        </fieldset>


        <div class="box-footer">
            <?= Html::Submitbutton(Yii::t('app', 'Create Contract').' '.Yii::t('app', 'and generate installments automatically'), ['class' => 'btn btn-primary btn-flat','onclick'=>"$('#smartwizard').smartWizard('loader', 'show');"]) ?>
            <?= Html::Submitbutton(Yii::t('app', 'Save As Draft'),  [
                'class' => 'btn btn-default',
                'onclick'=>"$('#smartwizard').smartWizard('loader', 'show');",
                'data' => ['method' => 'post','params' => ['is_draft' => true],
                ],
            ]) ?>
            
            <?php if ($model->isNewRecord) {
                echo Html::Submitbutton(Yii::t('app', 'Create Contract').' '.Yii::t('app', 'and generate installments manually'),  [
                    'class' => 'btn btn-default',
                    'onclick'=>"$('#smartwizard').smartWizard('loader', 'show');",
                    'data' => ['method' => 'post','params' => ['generate-installment' => true],
                    ],
                ]);
            }?>
        </div>
    <?php /*echo Html::button('Create New Company', ['value' => Url::to(['service/create']), 'title' => 'Viewing Company', 'class' => 'loadMainContent btn btn-success']);*/ ?>
    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
    </div>
 <?php /*Pjax::end();*/ ?>
 
<?php 
$script = <<< JS
$(document).ready(function(){
checkOrAdd();
});
JS;
$this->registerJs($script);
?>
