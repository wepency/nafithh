   <!-- Start Content -->
    <div class="site-content pad-50">
        <!-- Start Services Section -->
        <section class="partener-sec">
            <div class="container">
                <div class="row mb-4">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 align-self-center">
                        <div class="title mb-4">
                            <h4>
                                <img src="<?=Yii::$app->homeUrl?>images/pin.png">
                                <?= yii::t('app','Services We Seek To Provide')?>
                            </h4>
                        </div>
                        <p class="text-justify"><?= $setting->_services_text ?></p>  </div>
                </div>
                <div class="row">				
                <?php foreach($service as $row){	?>			
                
                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 ">
                        <div class="service-block">
                            <div class="service-img">
                                <img src="<?= $row->image ?>">
                            </div>
                            <div class="service-desc">
                                <h5><?= $row->_name ?></h5>
                                <p><?= $row->_body ?></p>
                            </div>
                        </div>
                    </div>
                   
                
				<?php } ?>
				</div>
            </div>
        </section>
        <!-- End Services Section -->
    </div>
    <!-- End Content -->
