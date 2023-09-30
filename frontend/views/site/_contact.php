<?php


use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
// print_r($dd); die();
?>
<?php Pjax::begin([]); ?>
    <div class="title mb-5">
        <h4>
            <img src="<?=Yii::$app->homeUrl?>images/pin.png">
            <?= yii::t('app','Contact us') ?>
        </h4>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-5">
        <?php if (Yii::$app->session->hasFlash('success')){ ?>
            <div class="modal fade"  id="modal-succes" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="alert alert-success alert-dismissable">
                                <?=Yii::$app->session->getFlash('success')?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= yii::t('app','Close') ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                $("#modal-succes").modal("show");
            </script>
        <?php }?>
        <?php if (Yii::$app->session->hasFlash('error')){ ?>
            <div class="alert alert-warning alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close btn" type="button">×</button>
                <?=Yii::$app->session->getFlash('error')?>
            </div>
        <?php }?>
    </div>
    <?php $form = ActiveForm::begin([
        'options' => ['method' => 'post','enctype' => 'multipart/form-data' , 'data' => ['pjax' => true],'class'=>''],
        'fieldConfig'=> [
            'inputOptions' => ['class' => 'form-control'],
            'labelOptions' => ['class' => 'form-label'],
            'options'=> ['class' => 'form-group'],
        ],
    ]); ?>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                    <?= $form->field($model, 'name')->textInput(['placeholder' => yii::t('app', 'Name')]) ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                <?= $form->field($model, 'email')->textInput(['placeholder' => yii::t('app', 'Email')]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                <?= $form->field($model, 'mobile')->textInput(['placeholder' => yii::t('app', 'Mobile')]) ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                <?= $form->field($model, 'contact_type_id')->dropDownList(ArrayHelper::map(\common\models\ContactType::find()->orderBy('sort_at ASC')->all(),'id','_title'),['prompt'=>Yii::t('app','Contact Type')])?>
            </div>
        </div> 
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                <?= $form->field($model, 'title')->textInput(['placeholder' => yii::t('app', 'Message Title')]) ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                <?= $form->field($model, 'msg')->textarea(['rows'=>4,'placeholder' => yii::t('app', 'Your Message')]) ?>
            </div>
        </div> 
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">    
                <div class="form-group ">
                    <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple'=>''])->label(yii::t('app', 'Attachement')) ?>
                </div>  
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                <?= Html::submitButton(yii::t('app', 'Send'), ['class' => 'btn btn-light custom-btn']) ?>
            </div>
        </div>                    
    <?php ActiveForm::end(); ?>
<?php Pjax::end(); ?> 
        
