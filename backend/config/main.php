<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'qr' => [
            'class' => '\Da\QrCode\Component\QrCodeComponent',
            // ... you can configure more properties of the component here
        ],
        // 'user2' => [
        //     'class' => 'yii\web\User',
        //     'identityClass' => 'common\models\User',
        //     'enableAutoLogin' => true,
        //     'identityCookie' => ['name' => '_identity-backend_2', 'httpOnly' => true],
        // ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        // 'assetManager' => [
        //     'bundles' => [
        //         'dmstr\web\AdminLteAsset' => [
        //             'skin' => 'skin-red',
        //         ],
        //     ],
        // ],
    ],
    'params' => $params,
    'as verificationControl' => [
        'class' => \common\behaviors\NafathValidatedFilter::class,
    ],
    'as beforeRequest' => [
        'class' => 'yii\filters\AccessControl',
        'except'=> ['site/login','site/error','site/request-password-reset','site/reset-password','site/verify-email','site/resend-verification-email','site/captcha','site/validate-signup','site/signup'],
        'rules' => [
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ],
        'denyCallback' => function () {
            return Yii::$app->response->redirect(['site/login']);
        },
    ],
    'as access' => [
        'class' => mdm\admin\components\AccessControl::class,
        'allowActions' => [
            'user/profile',
            'user/check-exists',
            'site/*',
            'dropdown/*',
            'export/*',
            'attachment/*',
            'gridview/export/download',
            'subscriptions/*',
            'takamolat/*',
            'coupons/*',
            'qr-code/*',
            // 'gridview/export/*'
            // 'story/*',
            // 'news/*',
            // 'partner/*',
            // 'errors/*',
            // 'subscribe/*',
            // 'program/*',
            // 'project/*',
            // 'purview/*',
            // 'contact-us/*',
            // 'social/*',
            // 'gallery/*',
            // 'report/*',
            // 'donate/*',
            // 'job/*',
            // 'volunteer/*',
            // 'applicant/*',
            // 'complaint/*',
        ]
    ],
];
