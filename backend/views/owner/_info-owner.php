<fieldset>
    <legend><?=Yii::t('app','Owner Information')?> :</legend>
    <div class='col-sm-12'>
		<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Identity Type') ?> </label> 

		<div class='col-sm-4 form-group'>
		    <label class='label-data'><?= $owner->identityType->name ?></label>
		</div>
		<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Identity Id') ?> </label> 

		<div class='col-sm-4 form-group'>
		    <label class='label-data'><?= $owner->identity_id ?></label>
		</div>

		<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Full Name') ?> </label> 

		<div class='col-sm-4 form-group'>
		    <label class='label-data'><?= $owner->name ?></label>
		</div>
		<?php if(yii::$app->user->identity->user_type != 'owner' && yii::$app->user->identity->user_type != 'renter' ){ ?>
			<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'black_list') ?> </label> 

			<div class='col-sm-4 form-group'>
			    <label class='label-data'><?= Yii::$app->params['yesNo'][Yii::$app->language][$owner->black_list] ?></label>
			</div>
		<?php } ?>
		<div class="clearfix"></div>
		<hr>
        
    </div>
</fieldset>
