<?php
$targt_lang = (Yii::$app->language == 'en') ? 'ar' : 'en';
if (Yii::$app->language == 'en') {
    $targt_lang = 'ar';
    $targt_lang_n = 'Ar';


} else {
    $targt_lang = 'en';
    $targt_lang_n = 'En';
}
$current_page = Yii::$app->controller->id;
$action_id = Yii::$app->controller->action->id;
?>
    <!-- Start Header -->
    <header class="header">
        <div class="container-fluid pl-0 top-header">
            <div class="row">
                <div class="col-lg-3 offset-lg-1 col-md-4 offset-md-1 col-sm-12 col-12 align-self-end">
                    <img src="<?= $setting->logo ?>" class="logo">
                </div>
                <div class="col-lg-8 col-md-7 col-sm-12 col-12">
                    <div class="contact-info">
                        <ul class="nav">
                            <li class="nav-item">
                                <div class="media">
                                    <div class="icon-photo align-self-center ml-3">
                                        <img src="<?= Yii::$app->homeUrl ?>images/icon-global.png">
                                    </div>
                                    <div class="media-body align-self-center text-right">
                                        <h5 class="mt-0"><?= yii::t('app', 'Company Headquarters') ?></h5>
                                        <p class="mb-0"><?= $setting->_address ?></p>

                                    </div>
                                </div>
                            </li>
                            <li class="nav-item">
                                <div class="media">
                                    <div class="icon-photo align-self-center ml-3">
                                        <img src="<?= Yii::$app->homeUrl ?>images/icon-email.png">
                                    </div>
                                    <div class="media-body align-self-center text-right">
                                        <h5 class="mt-0"><?= yii::t('app', 'Email') ?></h5>
                                        <p class="mb-0"><?= $setting->email ?></p>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item">
                                <div class="media">
                                    <div class="icon-photo align-self-center ml-3">
                                        <img src="<?= Yii::$app->homeUrl ?>images/whatsappline.png">
                                    </div>
                                    <div class="media-body align-self-center text-right">
                                        <a class="" target="_blank"
                                           href="https://api.whatsapp.com/send?phone=+966<?= $setting->mobile ?>;">
                                            <h5 class="mt-0"><?= yii::t('app', 'For inquiries') ?></h5>
                                            <p class="mb-0"><?= $setting->mobile ?></p>
                                        </a>
                                    </div>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a href="/admin" class="media">
                                    <div class="icon-photo align-self-center ml-3">
                                        <img src="<?= Yii::$app->homeUrl ?>images/user-account.png">
                                    </div>
                                    <div class="media-body align-self-center text-right">
                                        <?php if (Yii::$app->user->isGuest): ?>
                                            <h5 class="mt-0"><?= yii::t('app', 'login or register') ?></h5>
                                            <p class="mb-0"><?= Yii::t('app', 'login header subtitle') ?></p>
                                        <?php else: ?>
                                            <h5 class="mt-0"><?= yii::t('app', 'enter dashboard') ?></h5>
                                            <p class="mb-0"><?= Yii::t('app', 'click to visit dashboard') ?></p>
                                        <?php endif; ?>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <nav class="navbar navbar-expand-lg navbar-light header-menu">
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav main-menu">
                                <li class="nav-item <?php if ($current_page == 'site' && $action_id == 'index') { ?> active<?php } ?>">
                                    <a class="nav-link"
                                       href="<?= Yii::$app->homeUrl ?>"><?= yii::t('app', 'Home') ?></a>
                                </li>
                                <li class="nav-item <?php if ($current_page == 'about' && $action_id == 'index') { ?> active<?php } ?>">
                                    <a class="nav-link"
                                       href="<?= Yii::$app->homeUrl ?>about"><?= yii::t('app', 'know Us') ?></a>
                                </li>
                                <li class="nav-item  <?php if ($current_page == 'service' && $action_id == 'index') { ?> active<?php } ?>">
                                    <a class="nav-link"
                                       href="<?= Yii::$app->homeUrl ?>service"><?= yii::t('app', 'Our Services') ?></a>
                                </li>
                                <li class="nav-item  <?php if ($current_page == 'gallery') { ?> active<?php } ?>">
                                    <a class="nav-link"
                                       href="<?= Yii::$app->homeUrl ?>gallery"><?= yii::t('app', 'Nafithh gallery') ?></a>
                                </li>
                                <li class="nav-item <?php if ($current_page == 'plan') { ?> active<?php } ?>">
                                    <a class="nav-link"
                                       href="<?= Yii::$app->homeUrl ?>plan"><?= yii::t('app', 'Plans') ?></a>
                                </li>
                                <li class="nav-item <?php if ($current_page == 'partner' && $action_id == 'index') { ?> active<?php } ?>">
                                    <a class="nav-link"
                                       href="<?= Yii::$app->homeUrl ?>partner"><?= yii::t('app', 'Our partners') ?></a>
                                </li>
                                <!-- <li class="nav-item  <?php if ($current_page == 'subscribe' && $action_id == 'index') { ?> active<?php } ?>">
                                    <a class="nav-link" href="<?= Yii::$app->homeUrl ?>subscribe"><?= yii::t('app', 'Subscribe With Us') ?></a>
                                </li> -->
                                <li class="nav-item  <?php if ($current_page == 'contact-us' && $action_id == 'index') { ?> active<?php } ?>">
                                    <a class="nav-link"
                                       href="<?= Yii::$app->homeUrl ?>contact-us"><?= yii::t('app', 'Contact Us') ?></a>
                                </li>

                                <li class="nav-item lang">
                                    <a class="nav-link "
                                       href="<?= Yii::$app->homeUrl ?>site/language?language=<?= $targt_lang ?>"><?= Yii::t('app', $targt_lang_n) ?></a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <div class="mobile-header mobile-view">
            <div class="container-fluid">
                <div class="row no-gutters">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="logo-div">
                            <a href="JavaScript:;" class="menu-button">
                                <img src="<?= Yii::$app->homeUrl ?>images/icon-menu.png">
                            </a>
                            <a href="#" class="m-logo"><img src="<?= Yii::$app->homeUrl ?>images/logo-nafeza.png"></a>
                            <ul class="nav">
                                <li class="nav-item lang">
                                    <a class="nav-link" href="#">
                                        <a class="nav-link "
                                           href="<?= Yii::$app->homeUrl ?>site/language?language=<?= $targt_lang ?>"><?= Yii::t('app', $targt_lang_n) ?></a>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class="mobile-menu-overlay"></div>
            <div class="menu-mobile scroll scroll-wight-sidemenu">
                <div class="show-menu-mobile" style="display:;">
                    <div class="header-menu-mobile">
                        <div class="logo-opacity-bg">
                            <i class="fas fa-times close-menu"></i>
                            <img src="<?= Yii::$app->homeUrl ?>images/logo-nafeza.png" class="logo">
                        </div>
                        <ul class="nav nav-pills login-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:;"><?= $setting->email ?></a>
                            </li>

                            <li class="nav-item mr-auto">
                                <a class="nav-link"
                                   href="https://api.whatsapp.com/send?phone=+966<?= $setting->mobile ?>;"><?= $setting->mobile ?></a>
                            </li>

                            <li class="nav-item mr-auto">
                                <a class="nav-link" href="/admin"><?= Yii::t('app', Yii::$app->user->isGuest ? 'login or register' : 'enter dashboard') ?></a>
                            </li>

                        </ul>
                    </div>
                    <div class="body-menu-mobile">
                        <div class="fixed-menu">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item <?php if ($current_page == 'site' && $action_id == 'index') { ?> active<?php } ?>">
                                    <a class="nav-link" href="<?= Yii::$app->homeUrl ?>">
                                        <span><?= yii::t('app', 'Home') ?></span>
                                    </a>
                                </li>
                                <li class="list-group-item <?php if ($current_page == 'about' && $action_id == 'index') { ?> active<?php } ?>">
                                    <a class="nav-link" href="<?= Yii::$app->homeUrl ?>about">
                                        <span><?= yii::t('app', 'know Us') ?></span>
                                    </a>
                                </li>
                                <li class="list-group-item <?php if ($current_page == 'service' && $action_id == 'index') { ?> active<?php } ?>">
                                    <a class="nav-link" href="<?= Yii::$app->homeUrl ?>service">
                                        <span><?= yii::t('app', 'Our Services') ?></span>
                                    </a>
                                </li>
                                <li class="list-group-item <?php if ($current_page == 'gallery' && $action_id == 'index') { ?> active<?php } ?>">
                                    <a class="nav-link" href="<?= Yii::$app->homeUrl ?>gallery">
                                        <span><?= yii::t('app', 'Nafithh gallery') ?></span>
                                    </a>
                                </li>
                                <li class="list-group-item <?php if ($current_page == 'plan') { ?> active<?php } ?>">
                                    <a class="nav-link" href="<?= Yii::$app->homeUrl ?>plan">
                                        <span><?= yii::t('app', 'Plans') ?></span>
                                    </a>
                                </li>
                                <li class="list-group-item <?php if ($current_page == 'partner' && $action_id == 'index') { ?> active<?php } ?>">
                                    <a class="nav-link" href="<?= Yii::$app->homeUrl ?>partner">
                                        <span><?= yii::t('app', 'Our partners') ?></span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php if ($current_page == 'contact-us' && $action_id == 'index') { ?> active<?php } ?>">
                                    <a class="nav-link"
                                       href="<?= Yii::$app->homeUrl ?>contact-us"><?= yii::t('app', 'Contact Us') ?></a>
                                </li>
                                <!-- <li class="list-group-item <?php if ($current_page == 'contact' && $action_id == 'index') { ?> active<?php } ?>">
                                    <a class="nav-link" href="<?= Yii::$app->homeUrl ?>subscribe">
                                        <span><?= yii::t('app', 'Subscribe With Us') ?></span>
                                    </a>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- End Header -->


<?php
/*
use common\components\GeneralHelpers;
$banner = GeneralHelpers::getBannerAllPage();
$purviews = GeneralHelpers::getListPurviews();
$siteInfo = Yii::$app->SiteSetting->info(); 
$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
use yii\helpers\Html;





<header class="header">
    <div class="top-header">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-12">
                    <ul class="nav">
                        <?php  if (Yii::$app->user->isGuest) { ?>
                            
                            <li class="nav-item">
                                <a class="nav-link" href="<?=Yii::$app->homeUrl?>site/login"><?=Yii::t('app','Login');?></a>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item dropdown logined-user">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-user"></i><?=Yii::$app->user->identity->username?>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?=Yii::$app->homeUrl.'volunteer/basic-data'?>"><?=Yii::t('app','Basic Information');?></a>
                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item" href="<?=Yii::$app->homeUrl.'volunteer/info/'?>"><?=Yii::t('app','Personal Data');?></a>
                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item" href="<?=Yii::$app->homeUrl?>/volunteer/projects"><?=Yii::t('app','Volunteers project');?></a>
                                    <div class="dropdown-divider"></div>
                                    <?php print (Html::beginForm()
                                            . Html::a(
                                                 yii::t('app','Logout'),
                                                ['/site/logout'],['class' => 'dropdown-item' , 'data'=>['method' => 'post']]
                                            )
                                            . Html::endForm()
                                    ); ?>
                                </div>
                            </li>
                        <?php } ?>
                        <li class="line"><div></div></li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=Yii::$app->homeUrl?>subscribe"><?=Yii::t('app','Subscribe to Maillist');?></a>
                        </li>
                        <li class="line"><div></div></li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=Yii::$app->homeUrl?>job"><?=Yii::t('app','Employment');?></a>
                        </li>
                        <li class="line"><div></div></li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=Yii::$app->homeUrl?>donate"><?=Yii::t('app','Donation');?></a>
                        </li>
                        <li class="line"><div></div></li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=Yii::$app->homeUrl?>contact-us"><?=Yii::t('app','Contact Us');?></a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4 col-12 text-left">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link lang-link" href="<?=Yii::$app->homeUrl?>site/language?language=<?= $targt_lang ?>">
                                <span><?= $targt_lang_n?></span>
                                <img src="<?=Yii::$app->assetsUrl->baseUrl?>/langicon.png">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row main-header">
            <div class="col-md-4 col-12">
                <a href="<?=Yii::$app->homeURL?>">
                <?php if ($siteInfo->logo) {?>
                    <img src="<?=$siteInfo->logo?>" class="logo">
                <?php }else{ ?>
                    <img src="<?=Yii::$app->assetsUrl->baseUrl?>/logo.png" class="logo">
                <?php } ?> 
                </a>
            </div>
            <div class="col-md-8 col-12">
                <div class="add-size">
                 <?php if(!$banner){ ?>
                    <a href="<?=$banner->url?>">
                        <img src="<?=$banner->image?>">
                    </a>
                 <?php } else { ?>
                    <a href="#">
                        <img src="<?=Yii::$app->assetsUrl->baseUrl?>/adv2.png" style="width:1170px ;height: 135px">
                    </a>
                 <?php } ; ?>
                </div>  
            </div>
        </div>
        <div class="menu">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                    <ul class="navbar-nav nav-pills nav-fill">
                        <li class="nav-item <?= ($controller=='site' && $action=='index') ? 'active' : ''?>">
                            <a class="nav-link" href="<?=Yii::$app->homeURL?>"><?=yii::t('app','Homepage')?></a>
                        </li>
                        <li class="nav-item <?= ($controller=='about') ? 'active' : ''?>">
                            <a class="nav-link" href="<?=Yii::$app->homeURL?>about"><?=yii::t('app','About Us')?></a>
                        </li>
                        <li class="nav-item dropdown <?= ($controller=='program' || $controller=='purview' || $controller=='project') ? 'active' : ''?>">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?=Yii::t('app','Purviews');?>
                            </a>
                            <div class="dropdown-menu main-drop" aria-labelledby="navbarDropdown">
                                <div class="row">
                                    <?php foreach ($purviews as $purview ) { 
                                         if(!$purview->programs){
                                            break;
                                        }?>

                                        <div class="col-md-3 col-12">
                                            <div class="menue-block">
                                                <a class="dropdown-item" href="<?=Yii::$app->homeUrl.'purview/'.$purview->id?>">
                                                <h4><?=$purview->_title?></h4>
                                                </a>
                                                <?php foreach ($purview->programs as $program ) { ?>
                                                    <a class="dropdown-item" href="<?=Yii::$app->homeUrl.'program/'.$program->id?>"><?=$program->_name?></a>
                                                <?php } ?>

                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item <?= ($controller=='news') ? 'active' : ''?> ">
                            <a class="nav-link" href="<?=Yii::$app->homeURL?>news"><?=Yii::t('app','News and Events');?></a>
                        </li>
                        <li class="nav-item <?= ($controller=='story') ? 'active' : ''?> ">
                            <a class="nav-link" href="<?=Yii::$app->homeURL?>story"><?=Yii::t('app','Success Stories');?></a>
                        </li>
                        <li class="nav-item <?= ($controller=='gallery') ? 'active' : ''?> ">
                            <a class="nav-link" href="<?=Yii::$app->homeURL?>gallery"><?=Yii::t('app','Photo Archive');?></a>
                        </li>
                        <li class="nav-item <?= ($controller=='report') ? 'active' : ''?> ">
                            <a class="nav-link" href="<?=Yii::$app->homeURL?>report"><?=Yii::t('app','Reports');?></a>
                        </li>
                        <li class="nav-item <?= ($controller=='volunteer') ? 'active' : ''?> ">
                            <a class="nav-link" href="<?=Yii::$app->homeURL?>volunteer"><?=Yii::t('app','Volunteers');?></a>
                        </li>
                        <li class="nav-item <?= ($controller=='complaint') ? 'active' : ''?> ">
                            <a class="nav-link" href="<?=Yii::$app->homeURL?>complaint"><?=Yii::t('app','Complaints');?></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <div class="social-icon-fixed">
        <nav class="nav">
            <?php if($siteInfo->facebook!=""){?>
                <a class="nav-link fb" href="<?=$siteInfo->facebook?>">
                    <i class="fab fa-facebook-f"></i>
                </a>
            <?php }?>

            <?php if($siteInfo->twitter!=""){?>
            <a class="nav-link tw" href="<?=$siteInfo->twitter?>">
                <i class="fab fa-twitter"></i>
            </a>
            <?php }?>

            <?php if($siteInfo->youtube!=""){?>
            <a class="nav-link ytb" href="<?=$siteInfo->youtube?>">
                <i class="fab fa-youtube"></i>
            </a>
            <?php }?>

            <a class="nav-link glbl" href="<?=Yii::$app->homeUrl?>social">
                <i class="fas fa-globe"></i>
            </a>
        </nav>
    </div>
</header>
*/ ?>