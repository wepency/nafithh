<?php

namespace backend\controllers;

use common\models\EstateOffice;
use common\models\QrCode;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class QrCodeController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['estate_officer', 'owner_estate_officer'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
//                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $exportQrCode = new ExportController(1, new QrCode(1));
        $currentUser = \common\models\Chat::getInfoUser();

        if ($currentUser['userType'] == 'estate_officer') {
            $office = EstateOffice::findOne($currentUser['userId']);
        }

        $exportQrCode->setContent($office);

        $filePath = \Yii::getAlias("@webroot/../css");

        return $this->render('view', [
            'html' => $exportQrCode->html,
            'filePath' => $filePath.'/fonts/din-next'
        ]);
    }
}