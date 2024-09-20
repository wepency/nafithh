<?php
use common\widgets\Chart;
extract($option);
use yii\helpers\Arrayhelper;

?>

<div class="row">
	<div class="col-md-3">
		<?php echo Chart::card([
			'content' => $countEstate,
			'label' => yii::t('app','Number').yii::t('app',"Estate Office"),
			'color' => 'bg-aqua', 'icon' => 'fa fa-area-chart',
			'url' =>Yii::$app->homeUrl.'estate-office' ,

		]);?>
	</div>

	<div class="col-md-3">
		<?php echo Chart::card([
			'content' => $countMaintenance,
			'label' => yii::t('app','Number').yii::t('app',"Maintenance Office"),
			'color' => 'bg-green', 'icon' => 'fa fa-area-chart',
			'url' =>Yii::$app->homeUrl.'maintenance-office' ,

		]);?>
	</div>

	<div class="col-md-3">
		<?php echo Chart::card([
			'content' => $countEstateExpaire,
			'label' => yii::t('app','Number').yii::t('app',"Estate Office Expaired"),
			'color' => 'bg-light-blue-active', 'icon' => 'fa fa-area-chart',
			'url' =>Yii::$app->homeUrl.'estate-office' ,

		]);?>
	</div>

	<div class="col-md-3">
		<?php echo Chart::card([
			'content' => $countOwner,
			'label' => yii::t('app','Number').yii::t('app',"Owner"),
			'color' => 'bg-red', 'icon' => 'fa fa-area-chart',
			'url' =>Yii::$app->homeUrl.'owner' ,

		]);?>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<?php echo Chart::card([
				'content' => $countRenter,
				'label' => yii::t('app','Number').yii::t('app',"Renter"),
				'color' => 'bg-teal', 'icon' => 'fa fa-area-chart',
				'url' =>Yii::$app->homeUrl.'renter' ,
			]);?>
	</div>
	<div class="col-md-3">
		<?php echo Chart::card([
				'content' => $countNewChat,
				'label' => yii::t('app','Number').yii::t('app',"New Chat"),
				'color' => 'bg-yellow-active', 'icon' => 'fa fa-area-chart',
				'url' =>Yii::$app->homeUrl.'chat' ,

			]);?>
	</div>
	<div class="col-md-3">
		<?php echo Chart::card([
			'content' => $expense[0]['amount'],
			'label' => yii::t('app','Expenses Total'),
			'color' => 'bg-teal', 'icon' => 'fa fa-money',
			'url' =>Yii::$app->homeUrl.'system-expense' ,
		]);?>
	</div>
	<div class="col-md-3">
		<?php echo Chart::card([
			'content' => $income[0]['amount'],
			'label' => yii::t('app','Incomes Total'),
			'color' => 'bg-green', 'icon' => 'fa fa-money',
			'url' =>Yii::$app->homeUrl.'system-income' ,
		]);?>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="col-md-12">
			<?php echo Chart::pieChart([
				'label' => Yii::t('app','Buildings'),
				'divId' => 'pieChart1',
				'content' => $building,
				'content' => $building,
				// array lable type id ex {1 => 'read',2=> 'unread'}
				'contentLable' => $buildingType,
				// 'attCount' => 'name' ,
				// 'contentText' => 'user_type',
				// 'contentImage' => 'avatar' ,
				'url' =>Yii::$app->homeUrl.'building' ,
			]);?>
		</div>
		<div class="col-md-12">
			<?php
			$data1 = implode(',',ArrayHelper::map($contracts,'count','count'));
		    $data2 = implode(',',ArrayHelper::map($contracts,'amounts','amounts'));
			 echo Chart::barChart([
				'label' => Yii::t('app','Contract statistics for real estate offices'),
				'divId' => 'barChart',
				'values' => $estateOfficeNames,
				'list1' => [
					'label'=> Yii::t('app','Number').' '.Yii::t('app','Contracts'),
					'data' => $data1
				],
				'list2' => [
					'label'=> Yii::t('app','Total Amount'),
					'data' => $data2
				],
				// 'url' =>Yii::$app->homeUrl.'building' ,
			]);?>
		</div>
	</div>
	<div class="col-md-6">

		<?php echo Chart::boxList([
				'content' => $blackList,
				'contentTitle' => 'name' ,
				'contentText' => 'user_type',
				'contentAdd' => yii::t('app','User Type').': ',
				'contentImage' => 'avatar' ,
				'url' =>Yii::$app->homeUrl.'user' ,
				'label' => yii::t('app','Black List'),
			]);?>
		<?php echo Chart::boxList([
				'content' => $chat,
				'contentTitle' => 'title',
				'contentText' => 'sender_type',
				'contentAdd' => yii::t('app','User Type').': ',
				// 'contentImage' => 'avatar' ,
				'url' =>Yii::$app->homeUrl.'chat' ,
				'label' => yii::t('app','Chats'),
			]);?>
	</div>
</div>
