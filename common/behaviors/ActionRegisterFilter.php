<?php
namespace common\behaviors;

use Yii;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;
// use common\models\Course;
// use common\models\Profile;
// use common\models\StudentRegistration;
use yii\web\NotFoundHttpException;
use common\components\GeneralHelpers;


class ActionRegisterFilter extends ActionFilter
{

    public function beforeAction($action)
    {
        switch ($action->id) {
            case 'create':
                $test = GeneralHelpers::testActiveEstateOffice();
                if($test == false){
                     \Yii::$app->getSession()->setFlash('danger', Yii::t('app','You cannot add a contract due to the expiration of your subscription date or the expiration of the contract balance'));
                    return $action->controller->redirect(['index']);
                }
                break;
        }
            
        return parent::beforeAction($action);

        // } else {
        //     throw new NotFoundHttpException('The requested page does not exist.');
        // }
    }

    public function afterAction($action, $result)
    {
        return parent::afterAction($action, $result);
    }
}