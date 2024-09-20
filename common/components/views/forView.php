<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use common\components\GeneralHelpers;
?>

<?php if ($hidden_remove){ ?>
    <style>.kv-file-remove{display: none;}</style>
<?php }

if (!$files || empty($files)){
    $files = GeneralHelpers::updateImages($model);
}

if (!$files || empty($files)){
    return '';
}

echo FileInput::widget([
        // 'form' => $form,
        'options' => [
            'multiple'=>true,
            'disabled'=> (bool) $hidden_remove,
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
        ],
    ]);


// example

// [
//    'format'=>'raw',
//    'label'=>yii::t('app','Attachments'),
//    'value'=> function($model) {
//         $attWidget =  new \common\components\MultiAttachmentWidget(['model'=>$model]);
//            return $attWidget->runForView();
//        }
// ],


// example advanced
// if images not use GeneralHelpers::updateImages($model), and have Form
// new \common\components\MultiAttachmentWidget(['model'=>$model,'form'=>$form,'files'=>$arrImages2])

?>