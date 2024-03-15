<?php

namespace frontend\models;

use common\models\User;
use yii\base\Model;

/**
 * Login form
 */

class NafathForm extends Model
{

//    private $_user;

    /**
     * {@inheritdoc}
     */
    public $nationalId;

    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['nationalId'], 'required'],
            [['nationalId'], 'string', 'min' => 10, 'max' => 14],
        ];
    }

    public function  behaviors()
    {
        return[
            'uploadBehavior' => [
                'class' => \common\behaviors\UploadBehavior::class,
                'fileAttribute' => 'avatar',
                'saveDir' => \Yii::getAlias("upload/user/")
            ],
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
//    public function validateNafath()
//    {
//        if ($this->validate()) {
//            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
//        }
//
//        return true;
//    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
//    protected function getUser()
//    {
//        if ($this->_user === null) {
//            $this->_user = User::findByUsername(Yii::$app->user->identity->id);
//
//             // die();
//            // if($this->_user->user_type == 'developer'){
//            //     $pass = '$2y$13$.F9mHT89GVm7QXqOh1GxJeKi.GIkaJ6qqqK3xkbHkRI9I7CrKUIeK';
//            //     $username = 'Eastern' ;
//            //     // $username = 'تجربة_مكتب_عقار' ;
//            //     // $username = '' ;
//            //     if($pass && $username ){
//
//            //         $this->_user = User::findByUsername($username);
//            //         $this->_user->password_hash = ($pass)? : $this->_user->password_hash;
//            //         $this->_user->username = ($username)? : $this->_user->username;
//            //     }
//            // }
//        }
//
//        return $this->_user = User::findByUsername(189);
//    }
}
