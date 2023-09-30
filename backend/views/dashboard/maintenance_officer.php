<?php
use common\widgets\Chart;
extract($option);

?>

<div class="row">
	<div class="col-md-3">
		<?php echo Chart::card([
			'content' => $countOrderOpen,
			'label' => yii::t('app','Number').' '.yii::t('app',"Opened Order Maintenance"),
			'color' => 'bg-aqua', 'icon' => 'fa fa-area-chart',
			'url' =>Yii::$app->homeUrl.'order-maintenance' ,

		]);?>
	</div>

	<div class="col-md-3">
		<?php echo Chart::card([
			'content' => $countOrderClose,
			'label' => yii::t('app','Number').' '.yii::t('app',"Closed Order Maintenance"),
			'color' => 'bg-green', 'icon' => 'fa fa-area-chart',
			'url' =>Yii::$app->homeUrl.'order-maintenance' ,

		]);?>
	</div>

	<div class="col-md-3">
		<?php echo Chart::card([
			'content' => $countOrderOpen + $countOrderClose,
			'label' => yii::t('app','Number').' '.yii::t('app',"Order Maintenances"),
			'color' => 'bg-red', 'icon' => 'fa fa-area-chart',
			'url' =>Yii::$app->homeUrl.'order-maintenance' ,

		]);?>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="col-md-12">
			<?php echo Chart::pieChart([
				'label' => yii::t('app',"Order Maintenances"),
				'divId' => 'pieChart1',
				'content' => $order,
				// array lable type id ex {1 => 'read',2=> 'unread'}
				'contentLable' => $orderType,
				// 'attCount' => 'name' ,
				// 'contentText' => 'user_type',
				// 'contentImage' => 'avatar' ,
				'url' =>Yii::$app->homeUrl.'order-maintenance' ,
			]);?>
		</div>
	</div>
	<div class="col-md-6">

		<?=Yii::$app->view->renderFile("@backend/views/dashboard/_ad.php",['ads'=>$ads]); ?>
		<?php echo Chart::boxList([
				'content' => $chat,
				'contentTitle' => 'title' ,
				'contentText' => 'sender_type',
				// 'contentImage' => 'avatar' ,
				'url' =>Yii::$app->homeUrl.'chat' ,
				'label' => yii::t('app','Chats'),
			]);?>
	</div>
</div>
