<?php
namespace common\rbac; 



// 1- developer مطور
// 2- manager مدير مانجر
// 3- volunteerمتطوع
// 4- editorمحرر
// 5- manager complaintsالشكاوى
// 6- manager emoployment التوظيف
// 7- manager Volunteers المتطوعين
// 8- depart complaints managerمدير إدارة في الشكاوى

use Yii;
use yii\rbac\Rule;
use common\components\GeneralHelpers;

 /**  * Checks if user role matches user passed via params  */ 

 class UserUserTypeRule extends Rule {

    public $name = 'userUserType';     

    public function execute($user, $item, $params)     {         //check the role from table user         

        if(isset(\Yii::$app->user->identity->user_type))
             $user_type = \Yii::$app->user->identity->user_type;
        else
             return false;
     
            if ($item->name === 'developer') {
                return $user_type == 'developer';
            }elseif($item->name === 'admin') {
                return $user_type == 'developer' || $user_type == 'admin'; //manager is a child of developer
            }elseif($item->name === 'estate_officer') {

                if($user_type == 'estate_officer' && isset($params)){
                        return $this->testAccessEstateOffice($params);
                }
                return $user_type == 'estate_officer' || $user_type == 'developer' ; 

            }elseif($item->name === 'estate_officer_user') {

                if(($user_type == 'estate_officer_user' || $user_type == 'estate_officer') && isset($params)){
                        return $this->testAccessEstateOffice($params);
                }
                return $user_type == 'estate_officer_user' || $user_type == 'estate_officer' || $user_type == 'developer'; 

            }elseif($item->name === 'owner') {

                if($user_type == 'owner' && isset($params)){
                    return $this->testAccessOwner($params);
                }
                return $user_type == 'owner' || $user_type == 'developer';

            }elseif($item->name === 'maintenance_officer') {

                if(($user_type == 'maintenance_officer_user' || $user_type == 'maintenance_officer') && isset($params)){
                    return $this->testAccessMaintenanceOffice($params);
                }
                return $user_type == 'maintenance_officer'  || $user_type == 'developer'; 

            }elseif($item->name === 'maintenance_officer_user') {

                if(($user_type == 'maintenance_officer_user' || $user_type == 'maintenance_officer') && isset($params)){
                        return $this->testAccessMaintenanceOffice($params);
                }
                return $user_type == 'maintenance_officer_user' || $user_type == 'maintenance_officer' || $user_type == 'developer' ;
                
            }elseif($item->name === 'owner_estate_officer') {

                return $user_type == 'owner_estate_officer' || $user_type == 'developer' ;
                
            }elseif($item->name === 'renter') {

                if($user_type == 'renter' && isset($params)){
                    return $this->testAccessRenter($params);
                }
                return $user_type == 'renter' || $user_type == 'developer'; 

            } else {
                return false;
            }
    }


    protected function testAccessOwner($params)
    {
        $userId = yii::$app->user->identity->id;
        if(isset($params['building']) && ($post = $params['building'])){
            return ($post->owner_id === $userId)? true : false;
        }elseif(isset($params['contract']) && ($post = $params['contract'])){
            return ($post->owner_id === $userId)? true : false;
        }elseif(isset($params['installment']) && ($post = $params['installment'])){
            return (isset($post->contract->owner_id) && $post->contract->owner_id === $userId)? true : false;
        }elseif(isset($params['order-info']) && ($post = $params['order-info'])){
            return ($post->sender_type == 'owner' && $post->sender_id === $userId)? true : false;
        }elseif(isset($params['receipt-voucher']) && ($post = $params['receipt-voucher'])){
            return ($post->owner_id === $userId)? true : false;
        }elseif(isset($params['statement-receipt-catch']) && ($post = $params['statement-receipt-catch'])){
            return ($post->owner_id === $userId)? true : false;
        }elseif(isset($params['order-maintenance']) && ($post = $params['order-maintenance'])){
            return ($post->orderInfo->sender_type == 'owner' && $post->orderInfo->sender_id === $userId && $post->status < 10)? true : false;
        }
        else{
            return true;
        }
    }

    protected function testAccessRenter($params)
    {
        $userId = yii::$app->user->identity->id;
        if(isset($params['contract']) && ($post = $params['contract'])){
            return ($post->renter_id === $userId)? true : false;
        }elseif(isset($params['installment']) && ($post = $params['installment'])){
            return (isset($post->renter_id) && $post->renter_id === $userId)? true : false;
        }elseif(isset($params['order-info']) && ($post = $params['order-info'])){
            return ($post->sender_type == 'renter' && $post->sender_id === $userId)? true : false;
        }elseif(isset($params['order-maintenance']) && ($post = $params['order-maintenance'])){
            return ($post->orderInfo->sender_type == 'renter' && $post->orderInfo->sender_id === $userId && $post->status < 10)? true : false;
        }elseif(isset($params['housing']) && ($post = $params['housing'])){
            return ($post->contract && $post->contract->renter_id == $userId)? true : false;
        }
        else{
            return true;
        }
    }


    protected function testAccessEstateOffice($params)
    {
        $estate_office_id = GeneralHelpers::getEstateOfficeId();

        if(isset($params['building']) && ($post = $params['building'])){
            return (isset($post->estateContract))? true : false;
        }elseif(isset($params['contract']) && ($post = $params['contract'])){
            return ($post->estate_office_id === $estate_office_id)? true : false;
        }elseif(isset($params['installment']) && ($post = $params['installment'])){
            return (isset($post->contract->estate_office_id) && $post->contract->estate_office_id === $estate_office_id)? true : false;
        }elseif(isset($params['order-info']) && ($post = $params['order-info'])){
            return (($post->sender_type === 'estate_officer' || $post->send_to === 'estate_officer' ) && $post->estate_office_id === $estate_office_id)? true : false;
        }elseif(isset($params['receipt-voucher']) && ($post = $params['receipt-voucher'])){
            return ($post->estate_office_id === $estate_office_id)? true : false;
        }elseif(isset($params['statement-receipt-catch']) && ($post = $params['statement-receipt-catch'])){
            return ($post->estate_office_id === $estate_office_id)? true : false;
        }elseif(isset($params['order-maintenance']) && ($post = $params['order-maintenance'])){
            return (($post->orderInfo->sender_type === 'estate_officer' || $post->orderInfo->send_to === 'estate_officer' ) && $post->orderInfo->estate_office_id === $estate_office_id && $post->status < 10)? true : false;
        }
        else{
            return true;
        }
    }

    protected function testAccessMaintenanceOffice($params)
    {
        $maintenance_office_id = GeneralHelpers::getMaintenanceOfficeId();

        if(isset($params['order-maintenance']) && ($post = $params['order-maintenance'])){
            return ($post->status < 10 && $post->maintenance_office_id === $maintenance_office_id)? true : false;
        }elseif(isset($params['receipt-voucher']) && ($post = $params['receipt-voucher'])){
            return ($post->maintenance_office_id === $maintenance_office_id)? true : false;
        }else{
            return true;
        }
    }

}