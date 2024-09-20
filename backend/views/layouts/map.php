<?php

$setting = yii::$app->SiteSetting->info();

/* @var $this yii\web\View */
/* @var $model common\models\Setting */
/* @var $form yii\widgets\ActiveForm */
?>
<label for="name" class="col-sm-2 control-label"> <?=Yii::t('app', 'Search For Place')?> <span class="required" aria-required="true"> </span></label>
<div class='col-sm-10'>
    <div class="form-group" style="overflow:hidden"> 
        <div class="form-group no-margin-bottom">
            <div class="col-sm-12 padding_0">
                <div class="col-sm-10">
                    <input type="text" class="form-control no-border-radius" id="us2-address" placeholder="The Place"/>
                </div>
                   <?= $form->field($model, 'lat')->hiddenInput(['maxlength' => true, 'value'=>$model->lat, 'id'=>'us2-lat'])->label(false) ?>
                   <?= $form->field($model, 'lang')->hiddenInput(['maxlength' => true, 'value'=>$model->lang, 'id'=>'us2-lon'])->label(false) ?>
            </div>
         </div>
        
        <div id="us2" style="width: 100%; height: 400px;"></div>
        <div class="clearfix"></div>
    </div>
</div>
<?php 

$this->registerJsFile('https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyBg-ick3BgA97MfR3EDax7psToQ8lK77Dg',
    ['depends' => [dmstr\web\AdminLteAsset::class]]);
$this->registerJsFile('@web/js/locationpicker.js',
    ['depends' => [dmstr\web\AdminLteAsset::class]]);
if(empty($model->lat)){
$x = 21.485811;
$y = 39.19250479999999;
}else
{
$x = $model->lat;
$y = $model->lang;
}

$script = <<< JS
// console.log(google)
if(typeof google !== 'undefined'){
$('#us2').locationpicker({
    location: {latitude:$x , longitude:$y },
    radius: 0,
    zoom:11,
    inputBinding: {
        latitudeInput: $('#us2-lat'),
        longitudeInput: $('#us2-lon'),
        locationNameInput: $('#us2-address')
    },
    enableAutocomplete: true
});

}
JS;
$this->registerJs($script);

?>