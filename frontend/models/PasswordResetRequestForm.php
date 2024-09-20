<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\components\GeneralHelpers;
use yii\helpers\Html;


/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
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
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => yii::t('app','There is no user with this email address.')
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */

    public function sendEmail()
    {
        $user = User::findOne([
            'email' => $this->email,
            'status' => User::STATUS_ACTIVE
        ]);

        if ($user === null) {
            return false;
        }

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }
        $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);

        //print_r($resetLink); die();

        $to = $user->email;
        $toSms = $user->mobile;
        //$from = Setting::findOne(1)->email;
        $subject =yii::t('app','Reset your passowrd');
        $message = "
        <html>
        <head>
        <title>" . $subject . "</title>
        </head>
        <body>
        <div class=\"email-confirm\">
            <p>".yii::t('app', 'HELLO {username}', ['username' => $user->username]) ."!</p>
            <p>".yii::t('app', 'Continue to Passowrd Reset') .":</p>
            <p>".Html::a(Html::encode($resetLink), $resetLink) ."</p>
        </div>
        </body>
        </html>
        ";
        // if($user->user_type === "renter"){
            $messageSms = yii::t('app', 'Continue to Passowrd Reset') ." ".Html::encode($resetLink);
            GeneralHelpers::sendSms($toSms, $messageSms);
        // }
        return GeneralHelpers::sendEmail($to, $subject, $message);
    }
}
