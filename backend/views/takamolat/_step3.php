<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-body table-responsive">
    <div class="form-group">
        <label for="images" class="form-label required">صور الاعلان</label>
        <p class="text-muted">يرجى إضافة صور بجودة عالية لجذب الإنتباه للإعلان.</p>

        <?= \common\components\MultiAttachmentWidget::widget(['model'=>$model,'form'=>$form, 'files'=>$images, 'hidden_remove'=>true, 'required'=>empty($images)])?>
    </div>
</div>

<div class="box-footer">
    <?= Html::button(Yii::t('app', 'Next') . '<i class="glyphicon glyphicon-chevron-left"></i> ', [
        'class' => 'button button-primary mt-5 loadMainContent'
    ]) ?>
</div>