<?php

use yii\helpers\Html;
use common\models\Notification;
use yii\bootstrap\ActiveForm;
use \common\components\GeneralHelpers;
use yii\helpers\Url;

$setting = yii::$app->SiteSetting->info();

$logo = Html::img($setting->logo, ['height' => '50px']);

$targt_lang = (Yii::$app->language == 'en') ? 'ar' : 'en';
if (Yii::$app->language == 'en') {
    $targt_lang = 'ar';
    $targt_lang_n = 'عربي';
} else {
    $targt_lang = 'en';
    $targt_lang_n = 'English';
}

if (Yii::$app->user->identity->avatar) {
    $image = Yii::$app->uploadUrl->baseUrl . "/user/" . Yii::$app->user->identity->avatar;
} else {
    $image = Yii::$app->uploadUrl->baseUrl . "/user/default.png";
}

$notifications = Notification::find()->limit('10')->all();
$count = count(Notification::getUnread());
// print_r($notifications); die();
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">Nafithh</span><span class="logo-lg">' . $logo . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning"><?= $count ?></span>
                    </a>
                    <ul class="dropdown-menu">

                        <li class="header">
                            <?php if ($count > 0)
                                echo yii::t('app', 'You have') . ' ' . $count . ' ' . yii::t('app', 'New Notification');
                            else
                                echo yii::t('app', 'You do not have any') . ' ' . yii::t('app', 'New Notification');
                            ?>

                        </li>
                        <?php
                        foreach ($notifications as $key) { ?>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li class="<?= ($key->status_read == 0) ? 'list-group-item-success' : '' ?>">
                                        <a href="<?= Yii::$app->request->baseUrl . '/notification/' . $key->id ?>">
                                            <i class="fa fa-users text-aqua"></i><?= $key->content ?>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php }; ?>
                        <li class="footer">
                            <a href="<?= Yii::$app->request->baseUrl . '/notification' ?>"><?= yii::t('app', 'View All') ?></a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?= Html::img($image, ['width' => '25px', 'class' => "img-circle"]); ?>
                        <span class="hidden-xs"><?= Yii::$app->user->identity->name; ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <?= Html::img($image); ?>
                            <p>
                                <?= Yii::$app->user->identity->name; ?>
                                <small><?= Yii::$app->user->identity->name; ?></small>
                            </p>
                        </li>
                        <?php $list = \common\components\MultiUserType::activeUserTypes();
                        if (count($list) > 0) { ?>
                            <li class="user-body">
                                <div class="btn-group">
                                    <?php foreach ($list as $key => $value) { ?>
                                        <?= Html::a(
                                            $value,
                                            ['/site/login-as', 'userType' => $key],
                                            ['data-method' => 'post', 'class' => 'btn btn-default ']
                                        ) ?>
                                    <?php } ?>
                                </div>
                                <!-- /.row -->
                            </li>
                        <?php } ?>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?= Yii::$app->homeUrl ?>user/profile"
                                   class="btn btn-default btn-flat"><?= yii::t('app', 'Profile') ?></a>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    yii::t('app', 'Logout'),
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="nav-link active" href="<?= Yii::$app->homeUrl ?>site/language?language=<?= $targt_lang ?>"
                       class="lang-link"><?= Yii::t('app', $targt_lang_n) ?></a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<?php if (in_array(yii::$app->user->identity->user_type, ['estate_officer', 'owner_estate_officer']) && !GeneralHelpers::checkIfOfficeOnTrialPlan() && (GeneralHelpers::getAvailableBalance() < 50 || GeneralHelpers::getAvailableBalance('sms') < 50)) {

    $quotaMessage = Yii::t('app', 'Your quota is about to finish, you can {upgradeLink} now.', [
        'upgradeLink' => Html::a(Yii::t('app', 'upgrade'), Yii::$app->BaseUrl->baseUrl . '/plan/index'),
    ]);

    ?>

    <div class="alert header-alert bg-yellow-active" style="margin-bottom: 0">
        <i class="fa fa-exclamation-triangle"></i> <?= $quotaMessage ?>
    </div>

<?php } ?>

<?php if (in_array(yii::$app->user->identity->user_type, ['estate_officer', 'owner_estate_officer']) && GeneralHelpers::checkIfOfficeOnTrialPlan()) {

    $quotaMessage = Yii::t('app', 'Your are on trial plan, {upgradeLink} now to get more sms and contracts.', [
        'upgradeLink' => Html::a(Yii::t('app', 'upgrade'), Yii::$app->BaseUrl->baseUrl . '/plan/index'),
    ]);

    ?>

    <div class="alert header-alert bg-yellow-active" style="margin-bottom: 0">
        <?= $quotaMessage ?>
    </div>

<?php } ?>