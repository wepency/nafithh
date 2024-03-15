<?php

namespace backend\controllers;

use common\components\GeneralHelpers;
use common\models\Attachment;

class AttachmentController extends \yii\web\Controller
{

    public function actionDeleteFile($id, $attribute = "image", $className = null)
    {

        if ($className !== null) {
            $className = urldecode($className);
            if (class_exists($className)) {
                return \common\components\GeneralHelpers::deleteImages($className, $id, $attribute);
            }
        }

        return GeneralHelpers::deleteImages(Attachment::class, $id, 'file', 'Delete Row');
    }

}
