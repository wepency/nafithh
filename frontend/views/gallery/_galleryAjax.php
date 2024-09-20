<?php 

$adSubType = Yii::$app->request->get('ad_subtype',0);

use yii\widgets\Pjax;
?>
	<?php  Pjax::begin([]) ;?>
    <div class="gallary-div">
                       
		<div class="row">
			 <?php foreach($gallery as $row){ ?>
			<div class="col-lg-4 col-md-4 col-sm-6 col-12">
				<div class="gallary-block">
					<div class="gallary-img">
						<a href="<?=Yii::$app->homeURL?>gallery/<?=$row->id?>">
							<?php 
							if(!empty($row->attachments)){
								foreach($row->attachments as $image){ ?>
								<img src="<?=Yii::$app->uploadUrl->baseUrl."/attachment/".$image->file?>">
								<?php break; }
							}else{ ?>
							 <img src="<?=Yii::$app->homeUrl?>images/default.png">
							<?php } 

							if($row->for_sale==1  && $searchforRent === null){
								$price= $row->sale_price;
							?>
								<span class="badge badge-primary red-bage"><?=Yii::$app->params['estate_type'][Yii::$app->language][1]?></span>
							<?php }else{
								$price= $row->rent_price;?>
								<span class="badge badge-primary green-bage"><?=Yii::$app->params['estate_type'][Yii::$app->language][2]?></span>
							<?php } ?>
					   </a>
					</div>
					<div class="gallary-disc">
						<a href="<?=Yii::$app->homeURL?>gallery/<?=$row->id?>">
							<h5><?= $row->building_name ?></h5>
							
						</a>
						<p>
					<a href="https://maps.google.com/maps?q=<?= $row->lat ?>,<?= $row->lang ?>" target="_blank">		<i class="fas fa-map-marker-alt"></i>  </a>
							<span><?= $row->city->_name?? '' ?> - <?= $row->district->_name?? '' ?> </span>
						</p>
					</div>
					<div class="gallary-footer">
						<span><?= number_format($price) ?> SR</span>
					</div>
				</div>
			</div>
			<?php } ?>
			<div class="col-lg-12 col-md-12 col-sm-12 col-12 ">
			 
				<?= \yii\widgets\LinkPager::widget(['pagination' => $pages])?>
			 
			</div>
		</div>
			
	</div>
	<?php  Pjax::end([]) ;?>   