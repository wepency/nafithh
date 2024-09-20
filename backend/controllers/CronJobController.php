<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Contract;
use common\models\Installment;
use common\models\EstateOffice;
use yii\web\NotFoundHttpException;
use common\components\GeneralHelpers;

/**
 * AdController implements the CRUD actions for Ad model.
 */
class CronJobController extends Controller
{

	/*
	إشعارات قرب انتهاء عقد الإيجار 
	ترسل في نفس اليوم المحدد من قبل الإعدادات بحسب الفترة المحددة من تاريخ اليوم الحالي
	ستعمل الدالة يومياً
	*/
    public function actionExpirContract()
    {

        // فترة الأيام التي سيتم إر ارسال اشعارات بقرب انتهاء العقد ويتم الاعتماد من تاريخ اليوم وإنقاص فترة الأيام
    	$peroidDay = yii::$app->params['daysBeforeNotiMerit'];

        $date_covered_start = date("Y-m-d" , strtotime("-$peroidDay days") )." 00:00:00";
        $date_covered_end =   date("Y-m-d" , strtotime("-$peroidDay days") )." 23:59:00"; 

    	$rows = Contract::find()->where(['status' => 1])->andWhere(['BETWEEN','end_date',$date_covered_start , $date_covered_end])->all();
    	foreach ($rows as $row) {
    		$row->trigger(Contract::EVENT_NEAR_EXPIR);
    	}
    }

    /*
     قرب حلول العقد ويحسب من تاريخ المحدد من الاعدادات مقارنة بتاريخ بدء القسط
    */
    public function actionNearPaymentInstallment()
    {
        // الأيام التي سيتم إنقاصها من تاريخ اليوم للقيام بفحص التواري التي في اليوم السابق المحدد
    	$peroidDay = yii::$app->params['daysBeforeNotiMerit'];

        $date_covered_start = date("Y-m-d" , strtotime("-$peroidDay days") )." 00:00:00";
        $date_covered_end =   date("Y-m-d" , strtotime("-$peroidDay days") )." 23:59:00"; 

    	$rows = Installment::find()->where(['payment_status' => Installment::STATUS_UNPAID])->andWhere(['BETWEEN','start_date',$date_covered_start , $date_covered_end])->all();

    	foreach ($rows as $row) {
    		$row->trigger(Installment::EVENT_NEAR_PAYMENT);
    	}
    }


    /*
    قرب موحد إنتهاء فترة الأقساط
    */
    public function actionNearExpirInstallment()
    {
        // الأيام التي سيتم إنقاصها من تاريخ اليوم للقيام بفحص التواري التي في اليوم السابق المحدد
    	$peroidDay = yii::$app->params['daysBeforeNotiMerit'];

        $date_covered_start = date("Y-m-d" , strtotime("-$peroidDay days") )." 00:00:00";
        $date_covered_end =   date("Y-m-d" , strtotime("-$peroidDay days") )." 23:59:00"; 

    	$rows = Installment::find()->where(['NOT','payment_status' => Installment::STATUS_PAID])->andWhere(['BETWEEN','end_date',$date_covered_start , $date_covered_end])->all();

    	foreach ($rows as $row) {
    		$row->trigger(Installment::EVENT_NEAR_EXPIR);
    	}
    }


    public function actionNearExpirOffice()
    {
        // الأيام التي سيتم إنقاصها من تاريخ اليوم للقيام بفحص التواري التي في اليوم السابق المحدد
    	$peroidDay = yii::$app->params['daysBeforeNotiMerit'];

        $date_covered_start = date("Y-m-d" , strtotime("-$peroidDay days") )." 00:00:00";
        $date_covered_end =   date("Y-m-d" , strtotime("-$peroidDay days") )." 23:59:00"; 

    	$rows = EstateOffice::find()->where(['NOT','payment_status' => Installment::STATUS_PAID])->andWhere(['BETWEEN','expire_date',$date_covered_start , $date_covered_end])->all();

    	foreach ($rows as $row) {
    		$row->trigger(EstateOffice::EVENT_NEAR_EXPIR);
    	}
    }
}
