<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;

$setting = yii::$app->SiteSetting->info();

$targt_lang = (Yii::$app->language=='en') ? 'ar' : 'en';
   if (Yii::$app->language=='en'){
       $targt_lang = 'ar';
       $targt_lang_n = 'عربي';
   } else   {
       $targt_lang = 'en';
       $targt_lang_n = 'English';
   }

\Yii::$app->view->registerMetaTag([
    'property' => 'og:site_name',
    'content' => $setting->_site_name,
]);


AppAsset::register($this,$x=Yii::$app->language);

 


?>
 
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language?>" dir="<?= (Yii::$app->language=='en') ? 'ltr' : 'rtl'?>">


    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="shortcut icon" href="<?=Yii::$app->urlManager->baseUrl?>/images/favicon.ico">

        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>

      <?php if (Yii::$app->language=='en') {?>
        <link rel='stylesheet' href="<?=Yii::$app->urlManager->baseUrl?>/frontend\assets\css\style_en.css" >
      <?php } ?>


    </head>

    <body>

    <?php $this->beginBody() ?>

        <!-- Start Header -->
        <?=Yii::$app->view->renderFile('@frontend/views/layouts/header.php',['targt_lang' => $targt_lang , 'targt_lang_n' => $targt_lang_n,'setting'=>$setting]);?>
         <!-- End Heaader -->

        <?php if(!(Yii::$app->controller->id == 'site' &&  Yii::$app->controller->action->id == 'index')){  
		?>
       
        <?php }else{
			\Yii::$app->view->registerMetaTag([
					'name' => 'description',
					'content' => $setting->_description
			]);
			\Yii::$app->view->registerMetaTag([
					'name' => 'keywords',
					'content' => $setting->key_words
			]);
		}
			?>

        <?php /*        
        <?php if (Yii::$app->session->hasFlash('success')){ ?>
          <div class="alert alert-success alert-dismissable">
               <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
               <?=Yii::$app->session->getFlash('success')?>
          </div>
        <?php }?>

        <?php if (Yii::$app->session->hasFlash('error')){ ?>
          <div class="alert alert-warning alert-dismissable">
               <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
               <?=Yii::$app->session->getFlash('error')?>
          </div>
        <?php }?>
        <?php */ ?>

        <?=$content ?>

        <!-- Start Footer -->
        <?=Yii::$app->view->renderFile('@frontend/views/layouts/footer.php',['setting'=>$setting]);?>
        <!-- End Footer -->

        <a href="#" class="back-to-top"><i class="fas fa-angle-up"></i></a>

        <?php if (class_exists('yii\debug\Module')) {
            $this->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
        } ?>
       
    <?php $this->endBody() ?>

    </body>

</html>

<?php $this->endPage() ?>

