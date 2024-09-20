<?php
use yii\widgets\Pjax;
 ?>
<!-- Start Content -->
    <div class="site-content pad-50">
        <!-- Start Partener Section -->
        <section class="partener-sec">
            <div class="container">
                <div class="row mb-4">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 align-self-center">
                        <div class="title mb-4">
                            <h4>
                                <img src="<?=Yii::$app->homeUrl?>images/pin.png">
                                <?= yii::t('app','Success Partners') ?>
                            </h4>
                        </div>
                        <p class="text-justify"> <?= $setting->_partners_text?></p> </div>
                </div>  
                <div class="row">
				  <?php foreach($partner as $row){ ?>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-6 ">
                        <a href="<?=$row->url?>" target="_blank">
							<div class="partener-block">
								<img src="<?= $row->image?>">
							</div>
						</a>
                    </div>
				  <?php }?>
                </div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-12 ">
				 
					<?= \yii\widgets\LinkPager::widget(['pagination' => $pages])?>
				 
				</div>
            </div>
			
        </section>
        <!-- End Partener Section -->
		
    </div>
    <!-- End Content -->