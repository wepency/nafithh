<?php
$this->title = Yii::t('app', 'Subscribe Plans');
use yii\helpers\StringHelper; 
use yii\helpers\Html;
use common\components\GeneralHelpers;

\Yii::$app->view->registerMetaTag([
    'name' => 'twitter:title',
    'content' => yii::t('app','Subscribe Plans'),
]);



$background = ['pic-01.png','pic-02.png','pic-03.png'];

?>


<?php if(count((array) $model) == 0 ){
	throw new \yii\web\NotFoundHttpException(Yii::t('app', 'Sorry, there are no results!'));
} ?>

<style>
    :root {
        --white: white;
        --gray: #999;
        --lightgray: whitesmoke;
        --darkgreen: #2a9d8f;
        --popular: #ffdd40;
        --starter: #f73859;
        --essential: #00aeef;
        --professional: #ff7f45;
    }
    /* SWITCH STYLES
    –––––––––––––––––––––––––––––––––––––––––––––––––– */
    .switch-wrapper {
        position: relative;
        display: inline-flex;
        padding: 4px;
        border: 1px solid lightgrey;
        margin-bottom: 40px;
        border-radius: 30px;
        background: var(--white);
        direction: ltr;
    }

    .switch-wrapper [type="radio"] {
        display: none;
    }

    .switch-wrapper [type="radio"]:checked#monthly ~ label[for="monthly"],
    .switch-wrapper [type="radio"]:checked#yearly ~ label[for="yearly"] {
        color: var(--white);
    }

    .switch-wrapper [type="radio"]:checked#monthly ~ label[for="monthly"]:hover,
    .switch-wrapper [type="radio"]:checked#yearly ~ label[for="yearly"]:hover {
        background: transparent;
    }

    .switch-wrapper
    [type="radio"]:checked#monthly
    + label[for="yearly"]
    ~ .highlighter {
        transform: none;
    }

    .switch-wrapper
    [type="radio"]:checked#yearly
    + label[for="monthly"]
    ~ .highlighter {
        transform: translateX(100%);
    }

    .switch-wrapper label {
        font-size: 16px;
        z-index: 1;
        min-width: 100px;
        line-height: 32px;
        cursor: pointer;
        border-radius: 30px;
        transition: color 0.25s ease-in-out;
        -webkit-transition: color 0.25s ease-in-out;
        -moz-transition: color 0.25s ease-in-out;
        text-align: center;
    }
    .switch-wrapper .highlighter {
        position: absolute;
        top: 4px;
        left: 4px;
        width: calc(50% - 4px);
        height: calc(100% - 8px);
        border-radius: 30px;
        background: #ce9c2b;
        transition: transform 0.25s ease-in-out;
    }
</style>


<script>

</script>

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
                <div class="col-12 text-center">
                    <div class="switch-wrapper">
                        <input id="monthly" type="radio" name="switch" checked />
                        <input id="yearly" type="radio" name="switch" />
                        <label for="monthly">شهري</label>
                        <label for="yearly">سنوي</label>
                        <span class="highlighter"></span>
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
	                            <p class="mb-0"><span class="price"><?=$row->price + (float)GeneralHelpers::taxes($row->price)?></span> <?=Yii::$app->params['currency'][Yii::$app->language][$row->currency]; ?> / <?=Yii::$app->params['period'][Yii::$app->language][$row->period]; ?></p>
                                <h5 class="text-muted text-sm mt-0 mb-4" style="font-size:1rem;">السعر شامل الضريبة</h5>
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