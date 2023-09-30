<?php

namespace common\components;

use Yii;
use common\models\UserEstateOffice;
use common\models\User;
use common\models\UserMaintenanceOffice;
/**
 * OwnerController implements the CRUD actions for Owner model.
 */
class MultiUserType
{
    // public $_roleName;
    // public $_authManager;
    // تفعل فقط عند تهيئة النظام أو عند إضافة تعديلات لإضافة الحقول الجديدة لجدول المستخدم وإضافة القيم الإفتراضية للمستخدمين
    // add new \common\components\MultiUserType(); to any where for running the construct
    public function __construct()
    {
        // command 2
        // $table = \common\models\EstateOffice::getTableSchema();
        // if(!isset($table->columns['admin_id'])) {
        //    $ss = yii::$app->db->createCommand()->addColumn($table->name,'admin_id','int(10) unsigned')->execute();
        // }
        // foreach (\common\models\EstateOffice::find()->all() as $key) {
        //     if(isset($key->admin)){
        //         $key->admin_id = $key->admin->id;
        //         $key->save(false);
        //     }

        // }
        // $table = \common\models\MaintenanceOffice::getTableSchema();
        // if(!isset($table->columns['admin_id'])) {
        //    $ss = yii::$app->db->createCommand()->addColumn($table->name,'admin_id','int(10) unsigned')->execute();
        // }
        // foreach (\common\models\MaintenanceOffice::find()->all() as $key) {
        //     if(isset($key->admin)){
        //         $key->admin_id = $key->admin->id;
        //         $key->save(false);
        //     }
        // }

       // command 1 
        // $availableUserType =  yii::$app->params['userType'][Yii::$app->language];

        // foreach ($availableUserType as $key => $value) {
        //     $table = Yii::$app->db->schema->getTableSchema('user');
        //     if(!isset($table->columns[$key])) {
        //        $ss = yii::$app->db->createCommand()->addColumn('user',$key,'tinyint(2) null default 0')->execute();
        //     }
        // }

        // foreach (User::find()->all() as $key ) {
        //     $userType = $key->user_type;
        //     if(isset($key->$userType)){
        //         $key->$userType = 1;
        //         $key->save(false);
        //     }
        // }
    }

    // تسجيل الدخول كنوع مستخدم أو كدور أخر لدور المستخدم الحالي
    public static function loginAs($userType)
    {
        $user = yii::$app->user->identity;
        if(isset($user->{$userType}) &&  $user->{$userType} === 1){
            $session = Yii::$app->session;
            unset($session['estate_office_id']);
            unset($session['maintenance_office_id']);
            $user->user_type = $userType;
            $user->save(false);
            Yii::$app->session->setFlash('success', Yii::t('app','Login has been done successfully.'));
            // Yii::$app->user->logout();
            // Yii::$app->user->login($user, 3600 * 24 * 30);
        }else{
            $userType = Yii::$app->params['userType'][Yii::$app->language][$userType];
            Yii::$app->session->setFlash('danger',
                    yii::t('app','Failed when login as {userType} , please Contact Admin!',[
                        'userType' =>$userType
                    ])
            );
        }
    }

    // إضافة نوع مستخدم جديد إضافي لأحد المستخدمين

    public static function addUserType($user)
    {
       // new \common\components\MultiUserType();
        $availableUserType = self::allUserType();
        $message  = '';
        foreach ($availableUserType as $key => $value) {
           // $ss = yii::$app->db->createCommand()->addColumn('user',$key,'tinyint(2) null default 0')->execute();
            if($user->{$key} == $user->getOldAttribute($key) || $user->{$key} == 0 ){
                continue;
            }
            $message .= yii::t('app','Added User as {userType} has been done successfully',[ 'userType' =>$value]);
            switch ($key) {
                case 'owner':
                    
                    break;
                case 'renter':
                    $modelRenter = new \common\models\Renter();
                    $modelRenter->user_id = $user->id;
                    $modelRenter->save();
                    break;
                case 'estate_officer':
                case 'maintenance_officer':
                 // إضافة مكتب جديد ببيانات إفتراضية إذا تم منح المستخدم دور مكتب عقار أو صيانة
                    \backend\models\Signup::createOfficeFromUser($user,$key);
                    break;
                default:
                    $message .= yii::t('app','errors in User type');
                    continue 2;
                    break;
            }
            $userType = Yii::$app->params['userType'][Yii::$app->language][$key];
                           
        }
        return ['error'=>false , 'message' => $message];
    }

    // لحذف نوع  مستخدم من أحد المستخدمين
    // $userType تحتوي على النوع المراد حذفه أو إزالته للمستخدم
    public static function deleteUserType($user,$userType)
    {
        $availableUserType = self::availableUserType($user->id);
       
        foreach ($availableUserType as $key => $value) {
            if($key == $userType || $user->{$key} == 0){
                continue;
            }
            $user->user_type = $key;
            $user->{$userType} = 0;
            $user->save(false);
            // return ['error'=>true , 'message' => 'delete user type '.$userType];
            return true;
        }
        return false;
    }

   

    // أنواع المستخدم المتاحة لعرضها للمستخدم 
    public static function availableUserType($user_id = null)
    {
        $availableUserType = self::allUserType();
        $user = \common\models\User::findOne($user_id);
        if($user !== null){
            unset($availableUserType[$user->user_type]);
            if(UserEstateOffice::find()->where(['user_id' => $user_id])->one())
                unset($availableUserType['estate_officer']);
            if(\common\models\UserMaintenanceOffice::find()->where(['user_id' => $user_id])->one())
                unset($availableUserType['maintenance_officer']);
            // foreach ($availableUserType as $key => $value) {
            //     if($user->$key === 1)
            //         unset($availableUserType[$key]);
            // }
        }
        return $availableUserType;
    }

    

    // أنواع المستخدم المفعلة للمستخدم
    public static function activeUserTypes($user_id = null)
    {
        $availableUserType = yii::$app->params['userType'][Yii::$app->language];
        $user = \common\models\User::findOne(($user_id)? $user_id : yii::$app->user->identity->id);
        if($user !== null){
            unset($availableUserType[$user->user_type]);
            foreach ($availableUserType as $key => $value) {
                if($user->$key === 0)
                    unset($availableUserType[$key]);
            }
        }
        return $availableUserType;
    }


    public static function querySearch($user_type,&$query)
    {
        $query->where(['user_type'=>$user_type]);
        $table = Yii::$app->db->schema->getTableSchema('user');
        if(is_string($user_type) && isset($table->columns[$user_type])){
            $query->orWhere([$user_type => 1]);
        }
        if(is_array($user_type)){
            foreach ($user_type as $key) {
               if(isset($table->columns[$key])){
                    $query->orWhere([$key => 1]);
                }
            }
        }
    }


    // أنواع المستخدم المتاحة لإضافة المستخدم إليها
    private static function allUserType($user_id = null)
    {
        return array_diff_key( yii::$app->params['userType'][Yii::$app->language],array_flip(['admin','admin_user','estate_officer_user','maintenance_officer_user','owner_estate_officer']) );
    }


    // $user = \common\models\User::findOne($user_id);
    //     if($user === null){
    //         Yii::$app->session->setFlash('danger',
    //                 yii::t('app','This user does not exist.')
    //         );
    //         return false;
    //     }

    // if(isset($user->{$userType}) &&  $user->{$userType} === 1){
    //         Yii::$app->session->setFlash('danger',
    //                 yii::t('app','This account has already been activated')
    //         );
    //         return false;
    //     }

}
