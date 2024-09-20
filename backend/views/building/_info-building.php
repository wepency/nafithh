<fieldset>
    <legend><?=Yii::t('app','Building Info')?> :</legend>
    <div class='col-sm-12'>
		<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Building Name') ?> </label> 

		<div class='col-sm-4 form-group'>
		    <label class='label-data'><?= $building->building_name ?></label>
		</div>
		<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Owner') ?> </label> 

		<div class='col-sm-4 form-group'>
		    <label class='label-data'><?= $building->owner->name ?></label>
		</div>

		<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Building Type') ?> </label> 

		<div class='col-sm-4 form-group'>
		    <label class='label-data'><?= $building->buildingType->_name ?></label>
		</div>
		<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Instrument Number') ?> </label> 

		<div class='col-sm-4 form-group'>
		    <label class='label-data'><?= $building->instrument_number ?></label>
		</div>
		<div class="clearfix"></div>
		<hr>
        
    </div>
</fieldset>
