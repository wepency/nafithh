 <!-- Start Content -->
    <div class="site-content pad-100">
        <!-- Start About Section -->
        <section class="about-sec">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6  col-sm-12 col-12">
                        <div class="about-img">
                            
							<img src="<?=$setting->about_image?>">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 align-self-center">
                        <div class="title">
                            <h4>
                                <img src="<?=Yii::$app->homeUrl?>images/pin.png">
                                
								 <?= yii::t('app','Get To Know Nafithh up close')?>
                            </h4>
                        </div>
                        <p class="text-justify"><?=$setting->description ?> </p>
                    </div>
                </div>  
            </div>
        </section>
        <!-- End About Section -->
    </div>
    <!-- End Content -->