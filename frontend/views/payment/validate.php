<div class="site-content pad-50">
    <!-- Start Contact Section -->
    <section class="contact-sec">
        <div class="container">

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <?php if (Yii::$app->request->get('Result') == 'Successful') : ?>
                    <div class="alert alert-success text-center">
                        <div class="text-center">
                            <img style="max-width: 65px" src="<?= Yii::$app->homeUrl ?>images/success.png" alt="">
                        </div>

                        <h4>تم الاشتراك في الباقة بنجاح.</h4>

                        <a href="<?= Yii::$app->homeUrl?>admin/subscriptions" class="btn btn-success">قائمة اشتراكاتي</a>
                    </div>

                    <?php else : ?>

                        <div class="alert alert-danger text-center">
                            <div class="text-center">
                                <img style="max-width: 65px" src="<?= Yii::$app->homeUrl ?>images/danger.png" alt="">
                            </div>

                            <h4>هناك مشكلة في الاشتراك في الباقة</h4>

                            <a href="<?= Yii::$app->homeUrl?>plan" class="btn btn-danger">عرض الباقات</a>
                        </div>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>