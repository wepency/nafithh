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
                        <h4>
                            <img src="<?=Yii::$app->homeUrl?>images/pin.png">
                            <?=Yii::t('app','Subscribe Plans');?>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="row">
            	<?php foreach ($model as $row) { ?>
		            <div class="col-lg-4 col-md-4 col-sm-12 col-12 mb-5">
	                    <div class="price-block">
	                        <div class="package-title">
	                            <span><?=$row->_title?></span>
	                        </div>
	                        <img class="package-ico" src="<?=$row->image?>" alt="<?=$row->_title?>" >
	                        <div class="package-price" style="background-image:<?=Yii::$app->homeUrl.'/images/'.array_rand($background)?> ;">
	                            <p><span class="price"><?=$row->price?></span> <?=Yii::$app->params['currency'][Yii::$app->language][$row->currency]; ?> / <?=Yii::$app->params['period'][Yii::$app->language][$row->period]; ?></p>
	                        </div>
	                        <div class="package-desc">
	                            <ul>
	                            	<?php foreach ($row->planItems as $item) { ?>
			                            <li><?=$item->_title?></li>
		                            <?php } ?>
	                            </ul>
	                        </div>
	                        <?= Html::a(Yii::t('app', 'Subscribe Now'), ['/plan/order','plan_id' => $row->id], [
		                        'class' => 'btn btn-light black-btn',
		                        'type' => 'button',
		                    ]) ?>
	                    </div>
	                </div>
            	<?php } ?>
            </div>
        </div>
    </section>
</div>