<?php
$logo = (isset($estateOffice->footer_report_image))? $estateOffice->footer_report_image : '';
?>
<?php if($logo){ ?>
	<div class="row " bis_skin_checked="1">
		<div class="col-sm-12 col-xs-12 pad" bis_skin_checked="1">
            <div  style="height: 150px; text-align: center;">
                <img src="<?=$logo?>" style="height: 100%; width: auto;" class=" img-footer center-block img-responsive">
            </div>
		</div>
	</div>
<?php } ?>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                <p class="copyrights text-center">
                    <span><?= yii::t('app','Copyright ').date('Y');?></span>
                <a>
                        <span><?= yii::$app->SiteSetting->siteName()?></span>
                </a>
                <span><?= yii::t('app','All rights reserved');?></span>
                </p>
            </div>
        </div>
    </div>
</footer>