<?php

return [
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module',
        // enter optional module parameters below - only if you need to  
        // use your own export download action or custom translation 
        // message source
         'downloadAction' => 'gridview/export/download',
        // 'i18n' => []
        ],
        'redactor' => [
            'class' => 'yii\redactor\RedactorModule',
            'uploadDir' => '@upload/redactor',
            'uploadUrl' => '@web/../uploads/redactor',
            'imageAllowExtensions'=>['jpg','png','gif']
           
        ],
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'bootstrap' => [
        [
            'class' => 'common\components\LanguageSelector',
            'supportedLanguages' => ['en', 'ar'],
        ],
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone' => 'Asia/Riyadh',
    
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'SiteSetting'=>[
            'class'=>'common\components\SiteSetting',
        ],
        'urlManager' => [       
            'class' => 'yii\web\UrlManager',
                // Disable index.php
            'showScriptName' => false,
                // Disable r= routes
            'enablePrettyUrl' => true,
            'rules' => array(
                    '<controller:\w+>/<id:\d+>' => '<controller>/view',
                    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                    '<controller:[\w\-]+>/<id:\d+>' => '<controller>/view',
                    '<controller:[\w\-]+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                    '<controller:[\w\-]+>/<action:\w+>' => '<controller>/<action>',
            ),
        ],
        'sendGrid' => [
            'class' => 'bryglen\sendgrid\Mailer',
            'username' => 'apikey',
            'password' => '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',
            'viewPath' => '@common/mail', // your view path here
        ],
        'language' => 'ar',
        'sourceLanguage' => 'en',
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'formatter' => [
               'dateFormat' => 'd-M-Y',
               'datetimeFormat' => 'd-M-Y H:i:s',
               'timeFormat' => 'H:i:s',
               'defaultTimeZone' => 'Asia/Riyadh', // time zone
               'nullDisplay' => '',
               'locale' => 'en',
          ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\PhpManager'
            'defaultRoles' => ['developer','admin','admin_user','estate_officer','estate_officer_user','owner','maintenance_officer','maintenance_officer_user','renter','owner_estate_officer'],
        ],
        'uploadUrl' => [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => 'https://nafithh.com/uploads/',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'assetsUrl' => [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => 'https://nafithh.com/frontend/assets/image/',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'BaseUrl' => [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => 'https://nafithh.com/',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],

    ],
    
    
];
