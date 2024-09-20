<?php

use common\widgets\Chart;

extract($option);

?>

<div class="row">
    <div class="col-md-3">
        <?php echo Chart::card([
            'content' => \common\components\GeneralHelpers::getAvailableBalance(),
            'label' => yii::t('app', 'Contracts balance'),
            'color' => 'bg-yellow-active', 'icon' => 'fa fa-sticky-note',
            'url' => Yii::$app->homeUrl . 'contract/create'
        ]); ?>
    </div>

    <div class="col-md-3">
        <?php echo Chart::card([
            'content' => \common\components\GeneralHelpers::getAvailableBalance('sms'),
            'label' => yii::t('app', 'SMS balance'),
            'color' => 'small-box bg-teal', 'icon' => 'fa fa-area-chart',
            'url' => Yii::$app->homeUrl . 'subscriptions',

        ]); ?>
    </div>

    <div class="col-md-3">
        <?php echo Chart::card([
            'content' => $countContractOpen,
            'label' => yii::t('app', 'Number') . ' ' . yii::t('app', "Opened Contracts"),
            'color' => 'bg-aqua', 'icon' => 'fa fa-area-chart',
            'url' => Yii::$app->homeUrl . 'contract?ContractSearch[is_active]=1',

        ]); ?>
    </div>

    <div class="col-md-3">
        <?php echo Chart::card([
            'content' => $countContractClose,
            'label' => yii::t('app', 'Number') . ' ' . yii::t('app', "Closed Contracts"),
            'color' => 'bg-green', 'icon' => 'fa fa-area-chart',
            'url' => Yii::$app->homeUrl . 'contract?ContractSearch[is_active]=0',

        ]); ?>
    </div>

    <div class="col-md-3">
        <?php echo Chart::card([
            'content' => $countOwner,
            'label' => yii::t('app', 'Number') . ' ' . yii::t('app', "Owner"),
            'color' => 'bg-red', 'icon' => 'fa fa-area-chart',
            'url' => Yii::$app->homeUrl . 'owner',

        ]); ?>
    </div>
    <div class="col-md-3">
        <?php echo Chart::card([
            'content' => $InstaAll,
            'label' => yii::t('app', 'Number') . ' ' . yii::t('app', "Installements"),
            'color' => 'bg-light-blue-active', 'icon' => 'fa fa-area-chart',
            'url' => Yii::$app->homeUrl . 'installment',

        ]); ?>
    </div>

    <div class="col-md-3">
        <?php echo Chart::card([
            'content' => $InstaEnd,
            'label' => yii::t('app', 'Number') . ' ' . yii::t('app', "Installements") . ' ' . yii::t('app', "the belated"),
            'color' => 'bg-teal', 'icon' => 'fa fa-area-chart',
            'url' => Yii::$app->homeUrl . 'installment?belated=1',

        ]); ?>
    </div>
    <div class="col-md-3">
        <?php echo Chart::card([
            'content' => $InstaInMonth,
            'label' => yii::t('app', 'Number') . ' ' . yii::t('app', "Installements") . ' ' . yii::t('app', "In this Month"),
            'color' => 'bg-yellow-active', 'icon' => 'fa fa-area-chart',
            'url' => Yii::$app->homeUrl . 'installment?' . $installmentFilter,

        ]); ?>
    </div>

    <div class="col-md-3">
        <?php echo Chart::card([
            'content' => $expiredContracts,
//            'label' => yii::t('app',"In this Month"),
            'label' => 'عدد العقود المنتهية',
            'color' => 'bg-yellow-active', 'icon' => 'fa fa-area-chart',
            'url' => Yii::$app->homeUrl . 'contract?type=expired',

        ]); ?>
    </div>

    <div class="col-md-3">
        <?php echo Chart::card([
            'content' => $aboutToExpireContracts,
//            'label' => yii::t('app',"In this Month"),
            'label' => "عقود على وشك الانتهاء",
            'color' => 'bg-yellow-active', 'icon' => 'fa fa-area-chart',
            'url' => Yii::$app->homeUrl . 'contract?type=about_to_expire'

        ]); ?>
    </div>

    <div class="col-md-3">
        <?php echo Chart::card([
            'content' => $contractsWillExpireAfterMonths,
//            'label' => yii::t('app',"In this Month"),
            'label' => "عقود تنتهي من 71 يوم ل 89",
            'color' => 'bg-yellow-active', 'icon' => 'fa fa-area-chart',
            'url' => Yii::$app->homeUrl . 'contract?type=contracts_will_expire_after_months'

        ]); ?>
    </div>

    <div class="col-md-3">
        <?php echo Chart::card([
            'content' => $aboutToExpireInstallments,
//            'label' => yii::t('app',"In this Month"),
            'label' => "أقساط على وشك الانتهاء",
            'color' => 'bg-yellow-active', 'icon' => 'fa fa-area-chart',
            'url' => Yii::$app->homeUrl . "installment?type=aboutToExpire",

        ]); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="col-md-12">
            <?php echo Chart::pieChart([
                'label' => Yii::t('app', 'Buildings'),
                'divId' => 'pieChart1',
                'content' => $building,
                // array lable type id ex {1 => 'read',2=> 'unread'}
                'contentLable' => $buildingType,
                // 'attCount' => 'name' ,
                // 'contentText' => 'user_type',
                // 'contentImage' => 'avatar' ,
                'url' => Yii::$app->homeUrl . 'building',
            ]); ?>
        </div>
        <div class="col-md-12">
            <?php echo Chart::pieChart([
                'label' => Yii::t('app', 'Building Housing Units'),
                'divId' => 'pieChart2',
                'content' => $housing,
                // array lable type id ex {1 => 'read',2=> 'unread'}
                'contentLable' => $housingType,
                // 'attCount' => 'name' ,
                // 'contentText' => 'user_type',
                // 'contentImage' => 'avatar' ,
                'url' => Yii::$app->homeUrl . 'building',
            ]); ?>
        </div>
    </div>
    <div class="col-md-6">
        <?= Yii::$app->view->renderFile("@backend/views/dashboard/_ad.php", ['ads' => $ads]); ?>

        <?php echo Chart::boxList([
            'content' => $chat,
            'contentTitle' => 'title',
            'contentText' => 'sender_type',
            // 'contentImage' => 'avatar' ,
            'url' => Yii::$app->homeUrl . 'chat',
            'label' => yii::t('app', 'Chats'),
        ]); ?>
    </div>
</div>
