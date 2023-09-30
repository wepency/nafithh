<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use johnitvn\ajaxcrud\CrudAsset; 
CrudAsset::register($this);
use yii\bootstrap\Modal;

$userType = isset($userType)? $userType : '';
/* @var $this yii\web\View */
/* @var $model common\models\ProductOrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>

<div class="box-header with-border">
    <?php $form = ActiveForm::begin(['method' => 'post','action'=>['/user/check-exists'],'options'=>['class'=>"form_check_owner"]]); ?>
                <?=Html::hiddenInput("userType",$userType); ?>
        
        <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Identity Id')?></label>
        <div class='col-sm-4'>
            <input type="text" name="identity_id" class="form-control" value="" id="identity_id">
        </div>
        
        <div class="col-sm-2">
            <?= Html::button(Yii::t('app', 'Check or Add'), ['class' => 'btn btn-primary btn-flat loadMainContent']) ?>
        </div>
        

    <?php ActiveForm::end(); ?>
</div>

<?php 
$script = <<< JS
$(document).ready(function(){
     modal = new ModalRemote('#ajaxCrudModal');
    checkOrAdd = function(){
            $(".loadMainContent").on("click", function(event ){
                var form = $( this ).parent().parent();
                var formData = form.serialize();
                $.ajax({
                url: form.attr("action"),
                type: form.attr("method"),
                data: formData,
                success: function (data) {
                    modal.show();
                    modal.hidenCloseButton();
                    modal.setContent(data.content);
                    modal.setTitle(data.title);
                    modal.setFooter(data.footer);
                },
                error: function () {
                    alert("Something went wrong");
                }
                });
            });
        }
checkOrAdd();
});
JS;
$this->registerJs($script);
?>