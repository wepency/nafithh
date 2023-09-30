<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public function init()
    {

        parent::init();
        $this->css = [
            'css/fontawesome-all.min.css',
            'css/bootstrap.min.css',
            'css/jquery-ui.min.css',
            'css/owl.carousel.min.css',
            'css/owl.theme.default.css',
            'css/jquery.fancybox.min.css',
            'css/animate.css',
            //'css/style.css',
            //'css/style-en.css',
            'css/style_'.Yii::$app->language.'.css',
        ];
    }
    public $js = [
        //'js/jquery-3.3.1.min.js',
        'js/popper.min.js',
        'js/bootstrap.min.js',
        'js/easing.min.js',
        'js/wow.min.js',
        'js/owl.carousel.min.js',
        'js/classie.js',
        'js/jquery.ez-plus.js',
        'js/jquery.fancybox.min.js',
        'js/custom.js',
        
        
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
