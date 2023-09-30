<?php


namespace frontend\models;

use Yii;
use common\models\User;
use yii\base\Model;

class ResendVerificationEmailForm extends Model
{
    /**
     * @var string
     */
    public $email;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_DELETED],
                'message' => yii::t('app','This account has already been activated')
            ],
        ];
    }

     public function activationCode()
    {
        $user =  User::findOne(['email' => $this->email]);
        $min = pow(10,5);
        $max = pow(10,5+1)-1;
        $value = rand($min, $max);
        $user->activation_code = $value;
        //print_r($user->activation_code); die();
        
        return $user->save(false) ? $user : null;
    }

    /**
     * Sends confirmation email to user
     *
     * @return bool whether the email was sent
     */
    
}
