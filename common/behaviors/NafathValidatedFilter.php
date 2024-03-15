<?php
namespace common\behaviors;

use Yii;
use yii\base\ActionEvent;
use yii\base\Behavior;
use yii\base\Module;

class NafathValidatedFilter extends Behavior
{

    public function events()
    {
        return [
            Module::EVENT_BEFORE_ACTION => 'beforeAction',
        ];
    }

    public function beforeAction(ActionEvent $event)
    {
        $isAdmin = Yii::$app->user->identity?->user_type == 'admin';

        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->nafath_validated != 1 && !$isAdmin) {
            Yii::$app->session->setFlash('error', 'You must be verified to access this page.');
            Yii::$app->response->redirect(['../nafath/create']); // Redirect to the homepage or any other page
            return false; // Prevents the action from executing
        }

        return true;
    }
}