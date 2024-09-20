<?php
$arrImages = \common\components\GeneralHelpers::updateImages($model);
$form1 =  new \yii\widgets\ActiveForm();
?>

<fieldset>
    <legend><?=Yii::t('app','Order Maintenance Information')?> :</legend>
    <div class='col-sm-12'>
        <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Title')?></label>
        <div class='col-sm-4'>
            <label class="label-data"><?=$model->title?></label>
        </div>

        <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Sender')?></label>
        <div class='col-sm-4'>
            <label class="label-data"><?=$model->sender->name?></label>
        </div>
        <div class='clearfix'></div>

        <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Sender Type')?></label>
        <div class='col-sm-4'>
            <label class="label-data"><?=Yii::$app->params['userType'][Yii::$app->language][$model->sender_type]?></label>
        </div>

        <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Estate Office')?></label>
        <div class='col-sm-4'>
            <label class="label-data"><?=$model->estateOffice->name?></label>
        </div>
        <div class='clearfix'></div>

        <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Maintenance Type')?></label>
        <div class='col-sm-4'>
            <label class="label-data"><?=$model->maintenanceType->_name?></label>
        </div>

        <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Details Order')?></label>
        <div class='col-sm-4'>
            <label class="label-data"><?=$model->details_order?></label>
        </div>
       <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Attachments Before Fix') ?> </label>
        <div class='col-sm-10'>
            <?= \common\components\MultiAttachmentWidget::widget(['model'=>$model,'form'=>$form1,'files'=>$arrImages,'hidden_remove' =>true])?>
        </div>
	</div>
</fieldset>

<fieldset>
    <legend><?=Yii::t('app','Housing Unit Information')?> :</legend>
    <div class='col-sm-12'>

        <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Housing Unit Name')?></label>
        <div class='col-sm-10'>
            <label class="label-data"><?=$model->buildingHousingUnit->housing_unit_name?></label>
        </div>

        <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'City')?></label>
        <div class='col-sm-4'>
            <label class="label-data"><?=$model->buildingHousingUnit->building->city->_name?></label>
        </div>

        <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'District')?></label>
        <div class='col-sm-4'>
            <label class="label-data"><?=$model?->buildingHousingUnit?->building?->district?->_name?></label>
        </div>

        <div class="clearfix"></div>
        
        <?=Yii::$app->view->renderFile('@backend/views/layouts/view-map.php',['lang'=>$model->buildingHousingUnit->building->lang,'lat'=>$model->buildingHousingUnit->building->lat]);?>

        <div class="clearfix"></div>
    </div>
</fieldset>
