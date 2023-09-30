<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use common\models\RentPeriod;
use common\models\HousingUsingType;
use common\models\ContractFormEstateOffice;
use kartik\file\FileInput;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\BuildingHousingUnit */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Contract',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contracts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="building-housing-unit-form box box-primary">
	<?php $form = ActiveForm::begin(); ?>

    <div class="box-body table-responsive">
    	<fieldset>
            <div class='col-sm-12'>
				<?php if($model->is_draft === 1){ ?>
			        <?=Yii::$app->view->renderFile('@backend/views/contract/_form.php',['model'=>$model,'form'=>$form,'arrImages2'=>$arrImages2]);?>
				<?php }else{ ?>

			    	<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Rent Period')?></label>
					<div class='col-sm-4'>
					    <label class='label-data'><?= $model->rentPeriod->_name ?></label>
					</div>

					<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Housing Using Type')?></label>
					<div class='col-sm-4'>
					    <label class='label-data'><?= $model->housingUsingType->_name?? "" ?></label>
					</div>
					<div class="clearfix"></div>

					<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Contract Form')?></label>
					<div class='col-sm-4'>
					    <label class='label-data'><?= $model->contractForm->_name ?></label>
					</div>

					<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Number Installments')?></label>
					<div class='col-sm-4'>
					    <label class='label-data'><?= $model->number_installments ?></label>
					</div>

					<div class="clearfix"></div>

					<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Start Date')?></label>
					<div class='col-sm-4'>
					    <label class='label-data'><?= $model->start_date ?></label>
					</div>

					<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'End Date')?></label>
					<div class='col-sm-4'>
					    <label class='label-data'><?= $model->end_date ?></label>
					</div>

					<div class="clearfix"></div>
					<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Price')?></label>
					<div class='col-sm-4'>
					    <label class='label-data'><?= $model->price ?></label>
					</div>

					<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Price Text')?></label>
					<div class='col-sm-4'>
					    <label class='label-data'><?= $model->price_text ?></label>
					</div>

					<div class="clearfix"></div>

					<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Insurance Amount')?></label>
					<div class='col-sm-4'>
					    <label class='label-data'><?= $model->insurance_amount ?></label>
					</div>

					<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Include Electricity')?></label>
					<div class='col-sm-4'>
					    <label class='label-data'><?= Yii::$app->params['yesNo'][Yii::$app->language][$model->include_electricity] ?></label>
					</div>

					<div class="clearfix"></div>

					<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Include Water')?></label>
					<div class='col-sm-4'>
					    <label class='label-data'><?= Yii::$app->params['yesNo'][Yii::$app->language][$model->include_water] ?></label>
					</div>

					<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Water Amount')?></label>
					<div class='col-sm-4'>
						<label class='label-data'><?= $model->water_amount ?></label>
					</div>
					<div class="clearfix"></div>

					<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Include Maintenance')?></label>
					<div class='col-sm-4'>
					    <label class='label-data'><?= Yii::$app->params['yesNo'][Yii::$app->language][$model->include_maintenance] ?></label>
					</div>

					<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Ejar Contract No')?></label>
					<div class='col-sm-4'>
					    <label class='label-data'><?= $model->contract_no_ejar ?></label>
					</div>
					<div class="clearfix"></div>
					<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Attachments') ?> </label> 

					<div class='col-sm-10'>
					    <?= \common\components\MultiAttachmentWidget::widget(['model'=>$model,'form'=>$form,'files'=>$arrImages2])?>
					</div>

					<div class="clearfix"></div>
					<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Additional File') ?> </label>
					<div class='col-sm-10'>
					    <?php
					        echo $form->field($model, 'file')->widget(FileInput::class, [
					            'options' => ['accept' => 'any'],
					            'pluginOptions' => [
					                    'previewFileType' => 'any',
					                    'showUpload' => false,
					                    'showRemove' => true,
					                    'initialPreviewDownloadUrl'=>true,
					                    'initialPreviewConfig' => [array('type' => pathinfo($model->file, PATHINFO_EXTENSION),'downloadUrl' => $model->file)],
					                    'initialPreview'=> !empty($model->file) ? $model->file : '',
					                    'initialPreviewAsData'=>true,
					                    'deleteUrl' => Url::to(['contract/delete-file', 'id' => $model->id, 'attribute' => 'file']),
					            ],
					        ])->label(false);  ?>
					</div>
					<div class="clearfix"></div>
					<label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Details')?></label>
					<div class='col-sm-10'>

					        <?= $form->field($model, 'details')->textarea(['rows' => 6])->label(false) ?>
					</div>
				<?php } ?>
		   	</div>
        </fieldset>
    </div>
    <div class="box-footer">
        <?= Html::Submitbutton(Yii::t('app', 'Save Contract'), ['class' => 'btn btn-primary btn-flat']) ?>
        <?php
        if($model->is_draft === 1){
            echo Html::Submitbutton(Yii::t('app', 'Save As Draft'),  [
	            'class' => 'btn btn-default loadMainContent',
	            'data' => ['method' => 'post','params' => ['is_draft' => true]],
        	]);
        	echo Html::Submitbutton(Yii::t('app', 'Create Contract').' '.Yii::t('app', 'and generate installments manually'),  [
                    'class' => 'btn btn-default',
                    'data' => ['method' => 'post','params' => ['generate-installment' => true],
                    ],
                ]);
    	} 
    ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>