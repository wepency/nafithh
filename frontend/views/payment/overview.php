<?php
$this->title = Yii::t('app', 'Subscribe Plans');

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\GeneralHelpers;

$this->registerJsFile('@web/js/jquery-3.3.1.min.js', ['position' => yii\web\View::POS_HEAD]);

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
    .coupon-field {
        padding: 10px;
        height: 45px;
        border-radius: 10px;
    }

    .coupon-wrap .field {
        position: relative;
    }

    #validate-coupon {
        position: absolute;
        top: 5px;
        left: 5px;
        border-radius: 10px;
    }
</style>
>>>>>>> 34298e755ceea99b5ca1d34242cb463b64a9d2c8
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

                <div class="col-lg-6 col-md-6 col-sm-12 mb-5">
                    <div class="price-block">
                        <div class="package-title">
                            <span><?=$model->_title?></span>
                        </div>
                        <img class="package-ico" src="<?=$model->image?>" alt="<?=$model->_title?>">

                        <div class="package-price" style="background-image:<?=Yii::$app->homeUrl.'/images/'.array_rand($background)?> ;">
                            <p class="mb-0"><span class="price"><?=GeneralHelpers::currency($model->price + (float)GeneralHelpers::taxes($model->price))?></span></p>
                            <h5 class="text-muted text-sm mt-0 mb-4" style="font-size:1rem;">السعر شامل الضريبة</h5>
                        </div>

                        <div class="package-desc">
                            <ul>
                                <?php foreach ($model->planItems as $item) { ?>
                                    <li><?=$item->_title?></li>
                                <?php } ?>
                            </ul>
                        </div>

                        <?php $form = ActiveForm::begin(['action' => '/payment/do-pay', 'method' => 'post']); ?>

                        <?= Html::csrfMetaTags() ?>

                        <input type="hidden" name="planId" value="<?= $model->id ?>" />

                        <div class="coupon-wrap">
                            <div class="form-group">
                                <label for="coupon-check">هل لديك كود خصم بالفعل؟</label>

                                <div class="field">
                                    <input class="form-control coupon-field" name="couponCode" id="coupon-check" type="text" />
                                    <button id="validate-coupon" class="btn btn-dark"><i class="fa fa-recycle"></i> تفعيل </button>
                                </div>

                                <div class="alert alert-success mt-2 d-none" id="success-modal">
                                    <i class="fa fa-check-circle"></i> <span class="text"></span>
                                </div>

                                <div class="alert alert-danger d-none mt-2" id="error-modal">
                                    <i class="fa fa-times-circle"></i> <span class="text"></span>
                                </div>

                            </div>

                        </div>

                        <?= Html::submitButton("ادفع الأن <span id='final-price'>" . ($model->price + (float)GeneralHelpers::taxes($model->price)) . "</span>", ['class' => 'btn btn-light black-btn w-100', 'encode' => false]) ?>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<script>
    $('#validate-coupon').click(function (e){
        e.preventDefault();
        // $(this).attr('disabled', true)

        const $field = $(this).parents('.field');

        const CouponField = $field.find('input');
        // CouponField.attr('disabled', true);

        const couponCode = CouponField.val();
        const planId = '<?= $model->id ?>'

        $('#success-modal, #error-modal').addClass('d-none')

        $.ajax({
            url: '/payment/check-coupon',
            type: 'post',
            data: { couponCode: couponCode, planId: planId },
            headers: {
                'X-CSRF-Token': '<?= Yii::$app->request->csrfToken ?>',
            },
            success: function(response) {
                if (response.success) {
                    $('#final-price').text(response.finalPrice)
                    $('#success-modal').removeClass('d-none').find('span').text(response.message);
                }else {
                    $('#final-price').text(response.finalPrice)
                    $('#error-modal').removeClass('d-none').find('span').text(response.message);
                }
            },
            error: function(xhr, status, error) {

            }
        });
    });
</script>
