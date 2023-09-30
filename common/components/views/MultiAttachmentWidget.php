<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
if ($hidden_remove){
?>
<style>
.kv-file-remove{
	display: none;
}
</style>
<?php } ?>

<?php echo $form->field($model, 'imageFiles[]')->widget(FileInput::class, [
                    'options' => [
                        'multiple'=>true
                    ],
                    'name' => 'imageFiles[]',
                    'pluginOptions' => [
                            'showUpload' => false,
                            'showRemove' => false,
                            'initialPreview'=> !empty($model->imageFiles) ? $model->imageFiles : '',
                            'initialPreviewAsData'=>true,
                            'initialPreviewConfig'=> $files,
                            'overwriteInitial'=>false,
                            'previewFileType'=>'any',
                            //'deleteUrl' => Url::to(['product/delete-images']),
                    ],
                ])->label(false);  ?>