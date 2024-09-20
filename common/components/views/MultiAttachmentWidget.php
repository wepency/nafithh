<?php

use kartik\file\FileInput;

if ($hidden_remove) {
    ?>
    <style>
        .kv-file-remove {
            display: none;
        }
    </style>
<?php } ?>

<?php echo $form->field($model, 'imageFiles[]')->widget(FileInput::class, [
    'options' => [
        'multiple' => true,
        'required' => $required ?? false
    ],
    'name' => 'imageFiles[]',
    'pluginOptions' => [
        'showUpload' => false,
        'showRemove' => false,
        'initialPreview' => !empty($model->imageFiles) ? $model->imageFiles : '',
        'initialPreviewAsData' => true,
        'initialPreviewConfig' => $files,
        'overwriteInitial' => false,
        'previewFileType' => 'any',
        //'deleteUrl' => Url::to(['product/delete-images']),
//
//        'layoutTemplates' => [
//            'preview' => '<div class="file-preview {class}">' .
//                '    {close}' .
//                '    <div class="{dropClass}">' .
//                '    <div class="file-preview-thumbnails">' .
//                '    </div>' .
//                '    <div class="clearfix"></div>' .
//                '    </div>' .
//                '</div>',
//        ],
    ],
])->label(false); ?>