<?php

use mdm\admin\components\Helper;
use yii\helpers\Html;
use common\components\GeneralHelpers;
use common\models\Chat;

$userInfo = Chat::getInfoUser();
$myGallery =$myQR =  '';
if($userInfo['userType']=='estate_officer' && yii::$app->user->identity->user_type != 'owner_estate_officer'){
	$urlOffer = GeneralHelpers::urlMyOffer();
	$myGallery = Html::a('<i class="fa fa-building"></i>{label}</a>', $urlOffer, [
        'target'=>'_blank',
    ]);

//    $myQR = Html::a('<i class="fa fa-download"></i>{label}</a>',['/export/download'], [
//        'target'=>'_blank',
//    ]);

    $myQR = Html::a('<i class="fa fa-qrcode"></i>{label}</a>',['/qr-code/index'], [
//        'target'=>'_blank',
    ]);

}

?>
<aside class="main-sidebar">

    <section class="sidebar">
<?php $menuItems = [
    [
        'label' => \Yii::t('app','Global Categories'),
        'encode' => false,
        'icon' => 'list',
        'url' => '#',
        'items' => [
            ['label' => \Yii::t('app','Cities'), 'icon'=> 'globe', 'url' => ['/city/'], 'active' => in_array($this->context->route,['city/index','city/create','city/update','city/view'])],

			['label' => \Yii::t('app','Districts'), 'icon'=> 'map-marker', 'url' => ['/district/'], 'active' => in_array($this->context->route,['district/index','district/create','district/update','district/view'])],

			['label' => \Yii::t('app','Nationalities'), 'icon'=> 'globe', 'url' => ['/nationality/'], 'active' => in_array($this->context->route,['nationality/index','nationality/create','nationality/update','nationality/view'])],

			// ['label' => \Yii::t('app','Housing Unit Types'), 'icon'=> 'columns', 'url' => ['/housing-unit-type/'], 'active' => in_array($this->context->route,['housing-unit-type/index','housing-unit-type/create','housing-unit-type/update','housing-unit-type/view'])],

			['label' => \Yii::t('app','Housing Using Types'), 'icon'=> 'columns', 'url' => ['/housing-using-type/'], 'active' => in_array($this->context->route,['housing-using-type/index','housing-using-type/create','housing-using-type/update','housing-using-type/view'])],

			['label' => \Yii::t('app','Identity Types'), 'icon'=> 'address-card', 'url' => ['/identity-type/'], 'active' => in_array($this->context->route,['identity-type/index','identity-type/create','identity-type/update','identity-type/view'])],


			['label' => \Yii::t('app','Building Types'), 'icon'=> 'home', 'url' => ['/building-type/'], 'active' => in_array($this->context->route,['building-type/index','building-type/create','building-type/update','building-type/view'])],

			['label' => \Yii::t('app','Contract Forms'), 'icon'=> 'list-alt', 'url' => ['/contract-form/'], 'active' => in_array($this->context->route,['contract-form/index','contract-form/create','contract-form/update','contract-form/view'])],

			['label' => \Yii::t('app','Maintenance Types'), 'icon'=> 'cogs', 'url' => ['/maintenance-type/'], 'active' => in_array($this->context->route,['maintenance-type/index','maintenance-type/create','maintenance-type/update','maintenance-type/view'])],

			['label' => \Yii::t('app','Rent Periods'), 'icon'=> 'list-alt', 'url' => ['/rent-period/'], 'active' => in_array($this->context->route,['rent-period/index','rent-period/create','rent-period/update','rent-period/view'])],

			['label' => \Yii::t('app','Contact Type'), 'icon'=> 'list-alt', 'url' => ['/contact-type/'], 'active' => in_array($this->context->route,['contact-type/index','contact-type/create','contact-type/update','contact-type/view'])],

        ],
    ],

//    [
//        'label' => \Yii::t('app','Add new advertisement'),
//        'icon'=> 'home', 'url' => ['/takamolat/'],
//        'active' => in_array($this->context->route, ['takamolat/index','message-sms/view'])
//    ],
    [
        'label' => \Yii::t('app','Manage Site'),
        'encode' => false,
        'icon' => 'list',
        'url' => '#',
        'items' => [
			['label' => \Yii::t('app','Our Partners'), 'icon'=> 'users', 'url' => ['/partner/'], 'active' => in_array($this->context->route,['partner/index','partner/create','partner/update','partner/view'])],

			['label' => \Yii::t('app','Services'), 'icon'=> 'tasks', 'url' => ['/service/'], 'active' => in_array($this->context->route,['service/index','service/create','service/update','service/view'])],

			['label' => \Yii::t('app','Subscribers Order'), 'icon'=> 'users', 'url' => ['/subscribe/'], 'active' => in_array($this->context->route,['subscribe/index','subscribe/create','subscribe/update','subscribe/view'])],

			['label' => \Yii::t('app','Slider'), 'icon'=> 'photo', 'url' => ['/slider/'], 'active' => in_array($this->context->route,['slider/index','slider/create','slider/update','slider/view'])],

			['label' => \Yii::t('app','Plan'), 'icon'=> 'tasks', 'url' => ['/plan/'], 'active' => in_array($this->context->route,['plan/index','plan/create','plan/update','plan/view'])],

        ],
    ],

    ['label' => \Yii::t('app','System Expenses'), 'icon'=> 'money', 'url' => ['/system-expense/'], 'active' => in_array($this->context->route,['system-expense/index','system-expense/update','system-expense/create'])],

	['label' => \Yii::t('app','System Incomes'), 'icon'=> 'money', 'url' => ['/system-income/'], 'active' => in_array($this->context->route,['system-income/index','system-income/update','system-income/create'])],


	['label' => \Yii::t('app','Owners management'), 'icon'=> 'group', 'url' => ['/owner/index/'], 'active' => in_array($this->context->route,['owner/index','owner/update','owner/create'])],

	['label' => \Yii::t('app','Buildings'), 'icon'=> 'columns', 'url' => ['/building/index'], 'active' => in_array($this->context->route,['building/index','building/create','building/update','building/view'])],

	['label' => \Yii::t('app','Housing units'), 'icon'=> 'home', 'url' => ['/building-housing-unit/index'], 'active' => in_array($this->context->route,['building-housing-unit/index','building-housing-unit/create','building-housing-unit/update','building-housing-unit/view'])],

	['label' => \Yii::t('app','Renters management'), 'icon'=> 'group', 'url' => ['/renter/index/'], 'active' => in_array($this->context->route,['renter/index','renter/update','renter/create'])],

	['label' => \Yii::t('app','Contracts'), 'icon'=> 'sticky-note', 'url' => ['/contract/'], 'active' => in_array($this->context->route,['contract/index','contract/create','contract/update','contract/view'])],

	['label' => \Yii::t('app','Installements'), 'icon'=> 'money', 'url' => ['/installment/index'], 'active' => in_array($this->context->route,['installment/index','installment/create','installment/update','installment/view'])],

	['label' => \Yii::t('app','Installment Receipt Catches'), 'icon'=> 'money', 'url' => ['/installment-receipt-catch/index'], 'active' => in_array($this->context->route,['installment-receipt-catch/index','installment-receipt-catch/create','installment-receipt-catch/update','installment-receipt-catch/view'])],

	['label' => \Yii::t('app','Receipt Vouchers'), 'icon'=> 'money', 'url' => ['/receipt-voucher/'], 'active' => in_array($this->context->route,['receipt-voucher/index','receipt-voucher/create','receipt-voucher/update','receipt-voucher/view'])],

	[
        'label' => \Yii::t('app','Owners Statement'),
        'encode' => false,
        'icon' => 'list',
        'url' => '#',
        'items' => [
			['label' => \Yii::t('app','Owners Statement'), 'icon'=> 'users', 'url' => ['/statement/list-owner'], 'active' => in_array($this->context->route,['statement/index','statement/create','statement/update','statement/view','statement/list-owner'])],

			['label' => \Yii::t('app','Income and Expenses'), 'icon'=> 'users', 'url' => ['/statement/list-office'], 'active' => in_array($this->context->route,['statement/list-office','statement/office'])],

			['label' => \Yii::t('app','Receipt Catches'), 'icon'=> 'tasks', 'url' => ['/statement-receipt-catch/'], 'active' => in_array($this->context->route,['statement-receipt-catch/index','statement-receipt-catch/create','statement-receipt-catch/update','statement-receipt-catch/view'])],
        ],
    ],

	['label' => \Yii::t('app','Ads'), 'icon'=> 'photo', 'url' => ['/ad/'], 'active' => in_array($this->context->route,['ad/index','ad/create','ad/update','ad/view'])],

	['label' => \Yii::t('app','Contact Us'), 'icon'=> 'users', 'url' => ['/contact-us/'], 'active' => in_array($this->context->route,['contact-us/index','contact-us/create','contact-us/update','contact-us/view'])],

	['label' => \Yii::t('app','Order'), 'icon'=> 'users', 'url' => ['/order/'], 'active' => in_array($this->context->route,['order/index','order/create','order/update','order/view'])],


	['label' => \Yii::t('app','Notification Temp'), 'icon'=> 'bell', 'url' => ['/notif-temp/'], 'active' => in_array($this->context->route,['notif-temp/index','notif-temp/create','notif-temp/update','notif-temp/view'])],

	['label' => \Yii::t('app','Estate Offices'), 'icon'=> 'home', 'url' => ['/estate-office/'], 'active' => in_array($this->context->route,['estate-office/index','estate-office/create','estate-office/update','estate-office/view'])],

	['label' => \Yii::t('app','Maintenance Offices'), 'icon'=> 'home', 'url' => ['/maintenance-office/'], 'active' => in_array($this->context->route,['maintenance-office/index','maintenance-office/create','maintenance-office/update','maintenance-office/view'])],

	/* start part for Maintenance office  */
	['label' => \Yii::t('app','Order Maintenances'), 'icon'=> 'home', 'url' => ['/order-info/'], 'active' => in_array($this->context->route,['order-info/index','order-info/create','order-info/update','order-info/view'])],

	['label' => \Yii::t('app','Order Maintenances'), 'icon'=> 'home', 'url' => ['/order-maintenance/'], 'active' => in_array($this->context->route,['order-maintenance/index','order-maintenance/create','order-maintenance/update','order-maintenance/view'])],

	['label' => \Yii::t('app','Maintenance Invoices'), 'icon'=> 'fa-files-o', 'url' => ['/maintenance-invoice/index'], 'active' => in_array($this->context->route,['maintenance-invoice/index','maintenance-invoice/create','maintenance-invoice/update','maintenance-invoice/view'])],

	['label' => \Yii::t('app','Users'), 'icon' => 'users', 'url' => ['/user-maintenance-office/index/'], 'active' => in_array($this->context->route,['user-maintenance-office/index','user-maintenance-office/update','user-maintenance-office/view'])],

	['label' => \Yii::t('app','Setting'), 'icon'=> 'cogs', 'url' => ['/setting-maintenance-office/'], 'active' => in_array($this->context->route,['setting-maintenance-office/index'])],



	/* end part for Maintenance office  */


	/* start part for estate office  */


	['label' => \Yii::t('app','Bank Account Office'), 'icon'=> 'bank', 'url' => ['/bank-account-office/'], 'active' => in_array($this->context->route,['bank-account-office/index','bank-account-office/create','bank-account-office/update','bank-account-office/view'])],

	['label' => \Yii::t('app','Contract Forms'), 'icon'=> 'list-alt', 'url' => ['/contract-form-estate-office/'], 'active' => in_array($this->context->route,['contract-form-estate-office/index','contract-form-estate-office/create','contract-form-estate-office/update','contract-form-estate-office/view'])],

	['label' => \Yii::t('app','Notification Temp'), 'icon'=> 'bell', 'url' => ['/notif-temp-estate-office/'], 'active' => in_array($this->context->route,['notif-temp-estate-office/index','notif-temp-estate-office/create','notif-temp-estate-office/update','notif-temp-estate-office/view'])],

	['label' => \Yii::t('app','Users'), 'icon' => 'users', 'url' => ['/user-estate-office/index/'], 'active' => in_array($this->context->route,['user-estate-office/index','user-estate-office/update','user-estate-office/view'])],

	['label' => \Yii::t('app','Setting'), 'icon'=> 'cogs', 'url' => ['/setting-estate-office/'], 'active' => in_array($this->context->route,['setting-estate-office/index'])],

	/* end part for estate office  */


    ['label' => \Yii::t('app','Messages Sms'), 'icon'=> 'home', 'url' => ['/message-sms/'], 'active' => in_array($this->context->route,['message-sms/index','message-sms/create','message-sms/update','message-sms/view'])],

	['label' => \Yii::t('app','Messagess'), 'icon'=> 'home', 'url' => ['/chat/'], 'active' => in_array($this->context->route,['chat/index','chat/create','chat/update','chat/view'])],


	['label' => \Yii::t('app','Balance Contract'), 'icon'=> 'money', 'url' => ['/balance-contract/'], 'active' => in_array($this->context->route,['balance-contract/index','balance-contract/create','balance-contract/update','balance-contract/view'])],

	['label' => \Yii::t('app','Balance Sms'), 'icon'=> 'comments', 'url' => ['/balance-sms/'], 'active' => in_array($this->context->route,['balance-sms/index','balance-sms/create','balance-sms/update','balance-sms/view'])],

	['label' => \Yii::t('app','SMS Provider'), 'icon'=> 'mobile', 'url' => ['sms-provider/update/1/'], 'active' => in_array($this->context->route,['sms-provider/index','sms-provider/create','sms-provider/update','sms-provider/view'])],


    ['label' => \Yii::t('app','Settings'), 'icon'=> 'cog', 'url' => ['setting/update/1/'], 'active' => in_array($this->context->route,['setting/index','setting/create','setting/update','setting/view'])],

    [
        'label' => \Yii::t('app','Administration'),
        'icon' => 'users',
        'url' => '#',
        'items' => [
            ['label' => \Yii::t('app','Add User'), 'icon' => 'user-plus', 'url' => ['/user/create/'], 'active' => in_array($this->context->route,['user/create'])],
            ['label' => \Yii::t('app','Users'), 'icon' => 'users', 'url' => ['/user/index/'], 'active' => in_array($this->context->route,['user/index','user/update','user/view'])],
        ],
    ],
	['label' => \Yii::t('app','My Information'), 'icon'=> 'user', 'url' => ['/user/profile'], 'active' => in_array($this->context->route,['/user/profile'])],

    ['label' => \Yii::t('app','Nafithh gallery'), 'icon'=> 'building', 'url' => yii::$app->BaseUrl->baseUrl.'/gallery', 'template'=> '<a href="{url}" target="_blank"><i class="fa fa-building"></i>{label}</a>' ],

    ['label' => \Yii::t('app', 'My Offers'),'icon'=> 'building', 'url' => '', 'template'=> $myGallery ],
    ['label' => \Yii::t('app', 'QR Code'),'icon'=> 'qr-code', 'url' => '', 'template'=> $myQR ],

    ['label' => \Yii::t('app','Logout'),'icon' => 'sign-out', 'url' => ['site/logout'],'template'=>'<a href="{url}" data-method="post">{label}</a>'],
];
                ?>

        <?php

$menuItems = Helper::filter($menuItems);

if(in_array(yii::$app->user->identity->user_type,  ['estate_officer','owner_estate_officer'])){

    array_unshift($menuItems, [
        'label' => \Yii::t('app', 'Add new advertisement'),
        'icon' => 'home', 'url' => ['/takamolat/'],
        'active' => in_array($this->context->route, ['takamolat/index', 'message-sms/view'])
    ]);
}


        print dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => $menuItems,
            ]
        );

        ?>

    </section>

</aside>
