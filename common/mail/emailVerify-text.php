<?php
use yii\helpers\Html;
use yii\base\Model;

/* @var $this yii\web\View */
/* @var $user common\models\User */
//$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);

$confirmLink = Yii::$app->urlManager->hostInfo.'/site/verify-email?token='.$user->activation_code;
?>
<div class="email-confirm">
    <p><?= yii::t('app', 'HELLO {username}', ['username' => $user->username]); ?>!</p>
    <p><?= yii::t('app', 'FOLLOW_TO_CONFIRM_EMAIL') ?>:</p>
    <p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>
    <p><?= yii::t('app', 'IGNORE_IF_DO_NOT_REGISTER') ?></p>
</div>

