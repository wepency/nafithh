<fieldset>
    <legend><?=Yii::t('app','Housing Unit Information')?> :</legend>
    <div class='col-sm-12'>

		<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Housing Unit Name') ?> </label> 

		<div class='col-sm-4 form-group'>
		    <label class='label-data'><?= $housingUnit->housing_unit_name ?></label>
		</div>
		<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Using For') ?> </label> 

		<div class='col-sm-4 form-group'>
		    <label class='label-data'><?=Yii::$app->params['renterType'][Yii::$app->language][$housingUnit->using_for] ?></label>
		</div>

		<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Price') ?> </label> 

		<div class='col-sm-4 form-group'>
		    <label class='label-data'><?= $housingUnit->rent_price ?></label>
		</div>
		<div class="clearfix"></div>
		<hr>
        
    </div>
</fieldset>