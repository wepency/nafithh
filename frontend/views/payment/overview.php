<?php
$this->title = Yii::t('app', 'Subscribe Plans');
use yii\helpers\StringHelper;
use yii\helpers\Html;

\Yii::$app->view->registerMetaTag([
    'name' => 'twitter:title',
    'content' => yii::t('app','Subscribe Plans'),
]);



$background = ['pic-01.png','pic-02.png','pic-03.png'];

?>


<?php if(count((array) $model) == 0 ){
    throw new \yii\web\NotFoundHttpException(Yii::t('app', 'Sorry, there are no results!'));
} ?>


<div class="site-content padt-50">
    <section class="gray-sec">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12 align-self-center">
                    <div class="title mb-4">
                        <h4>المراجعة والدفع</h4>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 col-sm-12 mb-5">
                    <div class="price-block">
                        <div class="package-title">
                            <span><?=$model->_title?></span>
                        </div>
                        <img class="package-ico" src="<?=$model->image?>" alt="<?=$model->_title?>">
                        <div class="package-price" style="background-image: <?=Yii::$app->homeUrl.'/images/'.array_rand($background)?>;">
                            <p><span class="price"><?=$model->price?></span> <?=Yii::$app->params['currency'][Yii::$app->language][$model->currency]; ?> / <?=Yii::$app->params['period'][Yii::$app->language][$model->period]; ?></p>
                        </div>
                        <div class="package-desc">
                            <ul>
                                <?php foreach ($model->planItems as $item) { ?>
                                    <li><?=$item->_title?></li>
                                <?php } ?>
                            </ul>
                        </div>
                        <?= Html::a("ادفع الأن ".$model->price, ['/payment/do-pay','plan_id' => $model->id], [
                            'class' => 'btn btn-light black-btn w-100',
                            'type' => 'button',
                        ]) ?>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
