<?php
use yii\helpers\Html;
$setting = yii::$app->SiteSetting->info();


/* @var $this \yii\web\View */
/* @var $content string */
if (in_array(Yii::$app->controller->action->id,  ['login','request-password-reset','reset-password','verify-email','resend-verification-email'])) { 
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {

    if (class_exists('backend\assets\AppAsset')) {
        backend\assets\AppAsset::register($this);
    } else {
        app\assets\AppAsset::register($this);
    }

    $bundle = Yii::$app->assetManager->getBundle('dmstr\web\AdminLteAsset');
    $bundle->skin = $setting->admin_theme;
	
    
    if (Yii::$app->language=='ar'){
        airani\AdminLteRtlAsset::register($this);
		$this->registerCssFile('@web/css/custome.css', ['depends' => [airani\AdminLteRtlAsset::class]]);
    }else{
        dmstr\web\AdminLteAsset::register($this);
		$this->registerCssFile('@web/css/custome.css', ['depends' => [airani\AdminLteAsset::class]]);
	}
    // dmstr\web\AdminLteAsset::AdminLteAsset();
    // $bundle = Yii::$app->assetManager->bundles->dmstr\web\AdminLteAsset->skin = $setting->admin_theme;
    // print_r($bundle);


    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <?php if (!$setting->icon) {?>
            <link rel="shortcut icon" href="<?=$setting->icon?>">
        <?php }else{ ?>
            <link rel="shortcut icon" href="<?=Yii::$app->uploadUrl->baseUrl?>/favicon.ico">
        <?php } ?>
        <script type="text/javascript">
        function checkOrAdd(){};
        function downloadPdf(){};
        
        </script>
    </head>
    <body class="hold-transition <?= \dmstr\helpers\AdminLteHelper::skinClass() ?> sidebar-mini">
    <?php $this->beginBody() ?>

    <div class="wrapper">
        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
