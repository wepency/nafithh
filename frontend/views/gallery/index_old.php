<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\models\City;
use common\models\BuildingType;

 ?>
 <!-- Start Content -->
    <div class="site-content pad-50">
        <!-- Start Gallary Section -->
        <section class="gallary-sec">
            <div class="container">
			
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-6 col-12">
                        <div class="title mb-4">
                            <h4>
                                <img src="images/pin.png">
                                <?= yii::t('app','Search for Estates') ?>
                            </h4>
                        </div>
                    </div>
                </div>  
                <div class="search-block">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label> <?= yii::t('app','Type Of Estates') ?></label>
								<?= Html::dropDownList('building_type',[1],Yii::$app->params['building_type'][Yii::$app->language], ['prompt' => yii::t('app','Select Type'),'id'=>'building_type_id','class'=>'form-control estate_filter']) ?>
                       
                                 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label><?= yii::t('app','Category Of Estates') ?></label>
								<?= Html::dropDownList('estate_type',[],Yii::$app->params['estate_type'][Yii::$app->language], ['prompt' => yii::t('app','Select Category'),'id'=>'estate_type_id','class'=>'form-control estate_filter']) ?>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label><?= yii::t('app','City') ?></label>
								<?= Html::dropDownList('city',[],ArrayHelper::map(City::find()->where(['>','id',0])->all(),'id','_name'), ['prompt' => yii::t('app','Select City'),'id'=>'city_id','class'=>'form-control estate_filter']) ?>
                       
                               
                            </div>
                        </div>
                    </div>
                    <h4 style="color:#c6a53e">
                           <? //= yii::t('app','The offers are currently available for testing only,,, The service will be launched soon') ?>
                    </h4>
                </div>
                
				<div id="pjax_result">
					<?= $this->render('_galleryAjax',['gallery'=>$gallery, 'pages' => $pages,'searchforRent'=>$searchforRent]);?>
				</div>
            </div>
        </section>
        <!-- End Gallary Section -->
    </div>
    <!-- End Content -->
	<?php
$url = Url::toRoute('/gallery/index');
$script = <<< JS
    filterSearch = function(){
        dataForm = $(".estate_filter").serialize();
        $.ajax({
            url: "$url",
            type: 'get',
            //dataType: 'json',
            data: dataForm
        })
        .done(function(data) {
            $('#pjax_result').html(data);
        
        })
        .fail(function() {
            console.log("error");
        });
    };
       $(".estate_filter").change(function(event) {
			var building_type_id = $('#building_type_id').val();
			var estate_type_id = $('#estate_type_id').val();
			var city_id = $('#city_id').val();
            $.ajax({
                url: "$url",
                type: 'get',
                //dataType: 'json',
                data: {'building_type_id':building_type_id,'estate_type_id':estate_type_id,'city_id':city_id}
            })
            .done(function(data) {
                $('#pjax_result').html(data);
            
            })
            .fail(function() {
                console.log("error");
            });
        
        });


JS;
$this->registerJs($script);
?>