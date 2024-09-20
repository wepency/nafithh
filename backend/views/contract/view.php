<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\file\FileInput;

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\BuildingHousingUnit */
/* @var $form yii\widgets\ActiveForm */
$this->title = $contract->contract_no;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contracts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$estateOffice = $contract->estateOffice;

?>
<?php /*Pjax::begin([]);*/ ?>   


<?php

?>

<div class="building-housing-unit-index box box-primary template">
	<div id="divIdToPrint">

		<?=Yii::$app->view->renderFile('@backend/views/print/_header.php',['estateOffice'=>$estateOffice,'label' => Yii::t('app', 'Ejar System Contract Data')]);?>

		<?=Yii::$app->view->renderFile('@backend/views/contract/_temp.php',['model'=>$contract]);?>
		<?=Yii::$app->view->renderFile('@backend/views/print/_footer.php',['estateOffice'=>$estateOffice]);?>
	</div>
	
	<div class="col-lg-12 col-md-12 col-sm-12 col-12" data-html2canvas-ignore>
        <div class="clearfix"></div>
        <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();"> <?=yii::t('app','Print');?>
            <i class="fa fa-print"></i>
        </a>
        <a class="btn btn-lg green hidden-print margin-bottom-5" href="<?=Yii::$app->homeUrl?>contract"> <?=yii::t('app','Contracts');?>
            <i class="fa fa-check"></i>
        </a>
        <?= Html::a('<i class="fa fa-picture-o"></i>',null,  [
                'class'=>'btn btn-primary hidden-print', 
                'id'=>'down-jpg',
                // 'target'=>'_blank', 
                'data-toggle'=>'tooltip', 
                'title'=>'Will open the generated image file in a new window'
            ]);?>
        <?= Html::a('<i class="fa fa-download"></i>', null, [
                'class'=>'btn btn-primary hidden-print', 
                'id'=>'down-pdf',
                // 'target'=>'_blank', 
                'data-toggle'=>'tooltip', 
                'title'=>'Will open the generated PDF file in a new window'
            ]);?>
    </div>

	<div class="box-body table-responsive " data-html2canvas-ignore>

		<fieldset>
		    <legend><?=Yii::t('app','Attachments')?> :</legend>
				<div class='col-sm-12'>
					<div class='col-sm-12 col-md-12 col-lg-6'>
						<?php  	
							$attWidget =  new \common\components\MultiAttachmentWidget(['model'=>$contract,'hidden_remove'=>true]);
							echo $attWidget->runForView();
						?>
					</div>
					<div class='col-sm-12 col-md-12 col-lg-6'>
					<!-- <div class="clearfix"></div> -->
						    <?php
						    if($contract->file){
							    echo FileInput::widget([
								    'model' => $contract,
								    'attribute' => 'file',
								    'options' => ['accept' => 'any','disabled'=>true],
								    'pluginOptions' => [
								    	'previewFileType' => 'any',
					                    'showUpload' => false,
					                    'showRemove' => false,
					                    'initialPreviewDownloadUrl'=>true,
					                    'initialPreviewConfig' => [array('type' => pathinfo($contract->file, PATHINFO_EXTENSION),'downloadUrl' => $contract->file)],
					                    'initialPreview'=> !empty($contract->file) ? $contract->file : '',
					                    'initialPreviewAsData'=>true,
						            ],

								]); 
							}; 
							?>
					</div>
				</div>
        </fieldset>	

		<fieldset class="hidden-print">
			<legend><?=Yii::t('app','Installments')?> :</legend>
			<?php foreach ($contract->installments as $key) { ?>
				<div class='col-sm-12'>
					<div class='col-sm-2'>
						<label for='' class='control-label'><?=Yii::t('app', 'Installment No')?> : </label>
						<label class='label-data'><?=$key->installment_no?></label>
					</div>
					<div class='col-sm-2'>
						<label for='' class='control-label'><?=Yii::t('app', 'Payment Status')?> : </label>
						<label class='label-data'><?=Yii::$app->params['statusPayment2'][Yii::$app->language][$key->payment_status] ?></label>
					</div>
					<div class='col-sm-2'>
						<label for='' class='control-label'><?=Yii::t('app', 'Amount')?> : </label>
						<label class='label-data'><?=$key->amount ?></label>
					</div>
					<div class='col-sm-2'>
						<label for='' class='control-label'><?=Yii::t('app', 'End Date')?> : </label>
						<label class='label-data'><?=$key->end_date ?></label>
					</div>
					<div class='col-sm-2'>
					</div>
					<?php if(!$key->isPaid() && in_array(yii::$app->user->identity->role, ['estate_officer','developer'])){ ?>
						
						<div class='col-sm-push-2'>
							<label class='label-data'><?=Html::a(yii::t('app','installment payment'),
								['/installment-receipt-catch/create',
								'installment_id' => $key->id,
							],
							['class' => 'btn btn-success','role'=>'modal-remote']
							); ?></label>
						</div>
					<?php } ?>
				</div>
			<?php  } ?>
		</fieldset>
	</div>
</div>

<?php 
$crt = Yii::$app->request->csrfToken;
$script = <<< JS
 $('#down-pdf').click(function(){
downloadPdf("$contract->id","$crt");
        
    });
JS;
$this->registerJs($script);
?>
