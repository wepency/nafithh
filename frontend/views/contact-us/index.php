<?php
$this->title = Yii::t('app', 'Contact us');


// \Yii::$app->view->registerMetaTag([
//     'name' => 'twitter:title',
//     'content' => yii::t('app','Contact us'),
// ]);
?>


 <div class="site-content pad-50">
    <!-- Start Contact Section -->
    <section class="contact-sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <?=Yii::$app->view->renderFile('@frontend/views/site/_contact.php',['model'=>$model]);?>

                </div>
            </div>  
        </div>
    </section>
    <!-- End Contact Section -->
</div>
<!-- End Content -->