<?php

namespace frontend\controllers;

use yii\web\Controller;

class LandingController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}