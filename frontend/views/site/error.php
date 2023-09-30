<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = Yii::t('app','This page is not available');

?>
<section class="error-sec site-content padt-50">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="error text-center">
                        <img src="<?=Yii::$app->homeUrl?>images/404.png" style="max-height: 25em;" class="error-img">
                    </div>
                    <div class="text-center">
                        <h4 class="mb-30"><?=Yii::t('app','This page is not available');?></h4>
                        <!-- <h4 class="mb-30"><?= nl2br(Html::encode($message)) ?></h4> -->
                        <a class="btn btn-primary custom-btn" href="<?=Yii::$app->homeUrl;?>"><?=Yii::t('app','Homepage');?></a>
                    </div>
                </div>
            </div>  
        </div>
    </section>