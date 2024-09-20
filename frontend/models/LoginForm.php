<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    public $agreeTerm = 0;

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['agreeTerm', 'boolean'],

        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if($user && $user->validatePassword($this->password)){
                if ($user->confirmed == 0 || $user->status == 0) {
                    $this->addError('username', yii::t('app','Yor Account Not Active'));
                     return false;
                }

                if ($user->agree_term == 0) {
                    if ($this->agreeTerm == 1) {
                        $user->agree_term = 1;
                        $user->save(false);
                    }else{
                        $this->addError('agreeTerm', yii::t('app','you have agree to').' '.yii::t('app','Terms And Conditions'));
                    }
                }
            }else {

            $this->addError($attribute,  yii::t('app','Incorrect username or password.'));
                
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
             // die();
            // if($this->_user->user_type == 'developer'){
            //     $pass = '$2y$13$.F9mHT89GVm7QXqOh1GxJeKi.GIkaJ6qqqK3xkbHkRI9I7CrKUIeK';
            //     $username = 'Eastern' ;
            //     // $username = 'تجربة_مكتب_عقار' ;
            //     // $username = '' ;
            //     if($pass && $username ){

            //         $this->_user = User::findByUsername($username);
            //         $this->_user->password_hash = ($pass)? : $this->_user->password_hash;
            //         $this->_user->username = ($username)? : $this->_user->username;
            //     }
            // }
        }

        return $this->_user;
    }
}
