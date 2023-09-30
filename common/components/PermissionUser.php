<?php

namespace common\components;

use Yii;
// use common\models\Owner;
use mdm\admin\models\AuthItem;
use mdm\admin\components\ItemController;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
/**
 * OwnerController implements the CRUD actions for Owner model.
 */
class PermissionUser
{
    public $_roleName;
    public $_authManager;

     public function __construct($roleName = null)
    {

        $this->_roleName = $roleName;
        $this->_authManager =  yii::$app->user->authManager;
        if(!$roleName){
            throw new NotSupportedException(get_class($this) . ' $roleName is required.');
        }
        $authItem = AuthItem::find($this->_roleName);
        if(!($authItem)){
            throw new NotSupportedException(get_class($this) . 'role '.$this->_roleName.'is not exites');
        }
    }

    
    /**
     * Creates a new Owner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function listPermission()
    {
        $permission= array();
        // لحذف كل الصلاحيات الخافي النظام 
        // $roles = $this->deleteAll();
        // لإنشاء الصلاحيات بحسب الرول الحالي
        $roles = $this->createPermission();
        $roles = $this->permissions();

        foreach ($roles as $key => $value) {
            $permission[$value['controller']]['items'][] = ['name'=>$value['perDesc'],'key'=>$value['perName']];
        }
        return $permission;
    }


    public static function getPermissionsByUser($user_id)
    {

        // $per = $this->_authManager->getPermissionsByUser(105);
        $permission =  yii::$app->user->authManager->getAssignments($user_id);
        $per = array_keys($permission);
        return ($per)? :array();
    }

    public static function assignToUser($user)
    {
        $authManager = yii::$app->user->authManager;
        $items = $user->access;
        if(is_null($user) || !is_array($items) || is_null($items) )
            return false;
        $authManager->revokeAll($user->id);

        foreach ($items as $name) {
            // echo "<pre>";
            // print_r(self::SetPermissionsToRole('estate_officer','owner_estate_officer'));
            // die();
            try {
                $item = $authManager->getPermission($name);
                $authManager->assign($item, $user->id);
            } catch (\Exception $exc) {
                Yii::error($exc->getMessage(), __METHOD__);
            }
        }
        return true;
    }

    public function createPermission()
    {
        $roles = $this->permissions();
        $withOut = $this->withOut();
        foreach ($roles as $key => $value) {

            Yii::$app->i18n->translations['rbac-admin'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'basePath' => '@mdm/admin/messages',
            ];

            $model = new AuthItem($this->_authManager->getPermission($value['perName']));
            if(!isset($model->name)){
                $model = new AuthItem(null);
                $model->type = \yii\rbac\Item::TYPE_PERMISSION;
                $model->name = $value['perName'];
                $model->description = $value['perDesc'];
                $model->save();
            }

            $model->addChildren([$key]);

            if(isset($withOut[$value['controller']]) &&  $withOut[$value['controller']]['parent'] == $key ){
                $model->addChildren($withOut[$value['controller']]['child']);
            }
        }
    }

    // الصلاحيات المتاحة لدور المستخدم
    protected function permissions($roleName = null)
    {
        $roleName = $roleName? : $this->_roleName;
        $roles = yii::$app->user->authManager->getChildren($roleName);
        $roles = array_keys($roles);
        $permission= array();

        $withOut= $this->withOut();
        foreach ($roles as $key) {

            list(,$controller , $action ) = explode('/', $key);
            $action = ($action == '*')? 'all' : $action ;

            if(isset($withOut[$controller]) && in_array($key, $withOut[$controller]['child']))
                continue;

            $perName = Inflector::camelize($controller).'-'.Inflector::camelize($action);
            $perDesc= Inflector::camelize($action);

            $permission[$key] = ['perName'=>$perName,'perDesc' => $perDesc,'controller' => $controller];

        }
            
        return $permission;
    }


    public static function SetPermissionsToRole($roleName = null,$toRole)
    {
        $authManager = yii::$app->user->authManager;

        $roleName = $roleName;
        $roles = yii::$app->user->authManager->getChildren($roleName);
        $toRoleObject = yii::$app->user->authManager->getRole($toRole);
        $permission= array();

        foreach ($roles as $key) {
            $authManager->addChild($toRoleObject,$key);
        }
        return $permission;
    }


    protected function withOut()
    {
        return [
            'contract' => [
                'parent' => '/contract/create',
                'child' => [ 
                    '/contract/add-contract','/contract/add-housing-unit','/contract/check-or-add','/contract/step','/contract/check-or-add-renter','/contract/to-step','/contract/contract-form'
                ]
            ],
            'log-message' => [
                'parent' => 'noPerent',
                'child' => [ 
                    '/log-message/create','/log-message/update','/log-message/view','/log-message/index','/log-message/delete','/log-message/*'
                ]
            ],
        ];
    }

    protected function deleteAll()
    {
        $all =  (new \mdm\admin\models\searchs\AuthItem(['type' => \yii\rbac\Item::TYPE_PERMISSION]))->search(null);
           
        foreach ($all->allModels as $key) {
            $this->_authManager->remove($key);
        }
    }
}
