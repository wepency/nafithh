<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=nafit',
            'username' => 'root',
            'password' => '',
//            'dsn' => 'mysql:host=localhost;dbname=nafit',
//            'username' => 'root',
//            'password' => '',
            'charset' => 'utf8',
            'on afterOpen' => function($event) { 
                // set 'Asia/Bangkok' timezone
                $event->sender->createCommand("SET time_zone='+03:00';")->execute(); 
            },
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
            'transport' => [
                'scheme' => 'smtps',
                'dsn' => 'native://default',
                'class' => 'Symfony\Component\Mailer\Bridge\Smtp\Transport',
                'host' => 'mail.s1323.sureserver.com',
                'port' => 465,
                'encryption' => 'ssl',
                'username' => 'no-reply@nafithh.sa',
                'password' => 'tvR;=SPuYC--3oWq',
                'streamOptions' => [
                    'ssl' => [
                        'allow_self_signed' => true,
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ],
                ],
            ],
        ],
    ],
];
