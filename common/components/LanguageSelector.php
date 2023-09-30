<?php

namespace common\components;
 
use Yii;
use yii\base\BootstrapInterface;

class LanguageSelector implements BootstrapInterface
{
   /* public $supportedLanguages = ['ar','en'];

    public function bootstrap($app)
    {
        $preferredLanguage = $app->request->getPreferredLanguage($supportedLanguages);
        $app->language = $preferredLanguage;
    }*/
    public $supportedLanguages = [];

    public function bootstrap($app)
    {
        $preferredLanguage = isset($app->request->cookies['language']) ? (string)$app->request->cookies['language'] : 'ar';
        // or in case of database:
        // $preferredLanguage = $app->user->language;

        if (empty($preferredLanguage)) {
            $preferredLanguage = $app->request->getPreferredLanguage($this->supportedLanguages);
        }

       $app->language = $preferredLanguage;
    }
}
