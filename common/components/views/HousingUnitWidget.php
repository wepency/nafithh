<?php
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use common\models\housingUnitType;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
$EOS = yii::$app->SiteSetting->queryEOS();
use kartik\date\DatePicker;
use yii\redactor\widgets\Redactor;


?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h4><i class="glyphicon glyphicon-envelope"></i> <?= Yii::t('app','Housing Units')?></h4>
    </div>

    <div class="panel-body">
         <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapperHo', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
            'widgetBody' => '.container-itemsHo', // required: css class selector
            'widgetItem' => '.itemHo', // required: css class
            'limit' => 20, // the maximum times, an element can be cloned (default 999)
            'min' => 1, // 0 or 1 (default 1)
            'insertButton' => '.add-itemHo', // css class
            'deleteButton' => '.remove-itemHo', // css class
            'model' => $modelsHousings[0],
            'formId' => 'dynamic-form',
            'formFields' => [
                'housing_unit_name',
                'building_type_id',
                'using_for',
                'space',
                'floors_no',
                'rooms',
                'has_parking',
                'kitchen',
                'pool',
                'entrances',
                'toilets',
                'conditioner_num',
                'furniture',
                'detail',
                'status',
                'ad_subtype',
                'rent_price',
                'sale_price',
                'invest_price',
                /*'for_rent',
                'rent_price',
                'for_sale',
                'sale_price', */
            ],
        ]); ?>

        <div class="container-itemsHo"><!-- widgetContainer -->
            <?php foreach ($modelsHousings as $i => $modelHousing): ?>
                <div class="itemHo panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left"><?= Yii::t('app','Housing Unit')?></h3>
                        <div class="pull-right">
                            <button type="button" class="add-itemHo btn bg-green-active btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-itemHo btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                        // print_r( "[{$i}]"); die();
                            // necessary for update action.
                            if (! $modelHousing->isNewRecord) {
                                echo Html::activeHiddenInput($modelHousing, "[{$i}]id");
                            }
                        ?>
                        <div class="row">
                            <fieldset>
    							<div class='col-sm-12'>	
    								<div class='col-sm-3'><?= $form->field($modelHousing, "[{$i}]housing_unit_name")->textInput(['maxlength' => true]) ?></div>
    								<div class='col-sm-3'>
                                        <?= $form->field($modelHousing, "[{$i}]building_type_id")->widget(Select2::class, ['data' =>ArrayHelper::map($EOS['building_types']->where(['>','id',0])->all(),'id','_name'),'options' => ['prompt'=>Yii::t('app','Select Building Type')]]) ?>
                                     </div>
    								<div class='col-sm-3'><?= $form->field($modelHousing, "[{$i}]space")->textInput(['maxlength' => true]) ?></div>
    								<div class='col-sm-3'><?= $form->field($modelHousing, "[{$i}]floors_no")->textInput() ?></div>
    								<div class="clearfix"></div>		
    				
    								<div class='col-sm-3'><?= $form->field($modelHousing, "[{$i}]entrances")->textInput() ?></div>
    								<div class='col-sm-3'><?= $form->field($modelHousing, "[{$i}]rooms")->textInput() ?></div>
<!--                                    <div class='col-sm-3'>--><?php //= $form->field($modelHousing, "[{$i}]room_type")->textInput() ?><!--</div>-->
    								<div class='col-sm-3'><?= $form->field($modelHousing, "[{$i}]toilets")->textInput() ?></div>
    								<div class="clearfix"></div>		
    				
    								<div class='col-sm-3'><?= $form->field($modelHousing, "[{$i}]conditioner_num")->textInput() ?></div>
                                    <div class='col-sm-3'><?= $form->field($modelHousing, "[{$i}]lounge")->textInput() ?></div>
                                    <div class='col-sm-3'><?= $form->field($modelHousing, "[{$i}]electricity_meter_no")->textInput(['maxlength' => true]) ?></div>
<!--                                    --><?php //$modelHousing->isNewRecord ? $modelHousing->ad_subtype=0:$modelHousing->ad_subtype;?>
<!--                                    <div class='col-sm-3'>--><?php //= $form->field($modelHousing, "[{$i}]ad_subtype")->radioList(Yii::$app->params['adsubtype'][Yii::$app->language])->label(Yii::t('app', 'Ad Sub Type')) ?><!--</div>-->
                                    <div class="clearfix"></div>
                                    
    								<div class='col-sm-3'><?= $form->field($modelHousing, "[{$i}]using_for")->radioList(Yii::$app->params['renterType'][Yii::$app->language]) ?></div>
    								<div class='col-sm-3'><?= $form->field($modelHousing, "[{$i}]kitchen")->radioList(Yii::$app->params['yesNo'][Yii::$app->language]) ?></div>
    								<div class='col-sm-3'><?= $form->field($modelHousing, "[{$i}]has_parking")->radioList(Yii::$app->params['yesNo'][Yii::$app->language]) ?></div>
    								<div class='col-sm-3'><?= $form->field($modelHousing, "[{$i}]pool")->radioList(Yii::$app->params['yesNo'][Yii::$app->language]) ?></div>
                                    <div class="clearfix"></div> 

<!--                                    <label for='' class='col-sm-12 control-label' style="font-weight:bold !important;" >--><?php //= Yii::t('app', 'Limits and Lengths of the Property') ?><!-- </label>-->
<!--                                    <div class='col-sm-3'>--><?php //= $form->field($modelHousing, "[{$i}]length")->textInput(['maxlength' => true]) ?><!--</div>-->
<!--                                    <div class='col-sm-3'>--><?php //= $form->field($modelHousing, "[{$i}]width")->textInput(['maxlength' => true]) ?><!--</div>-->
<!--                                    <div class="clearfix"></div>-->
<!--                                    <div class='col-sm-6'>-->
<!--                                        --><?php //= $form->field($modelHousing, "[{$i}]ad_description")->textInput(['placeholder'=>Yii::t('app', 'Example: a two-story apartment in Al-Falah neighborhood')]) ?>
<!--                                    </div>-->
<!--                                    <div class="clearfix"></div> -->
<!--                                    <div class='col-sm-6'>-->
<!--                                        --><?php //= $form->field($modelHousing, "[{$i}]ad_publish_date")->widget(DatePicker::class,[
//                                            'type' => DatePicker::TYPE_INPUT,
//                                            'value' => '23-Feb-1982',
//                                            'pluginOptions' => [
//                                                'autoclose'=>true,
//                                                'todayHighlight' => true,
//                                                'format' => 'yyyy-mm-dd'
//                                            ],
//
//                                        ]); ?>
<!--                                    </div>-->
<!--                                    <div class='col-sm-6'>-->
<!--                                        --><?php //= $form->field($modelHousing, "[{$i}]ad_expire_date")->widget(DatePicker::class,[
//                                            'type' => DatePicker::TYPE_INPUT,
//                                            'value' => '23-Feb-1982',
//                                            'pluginOptions' => [
//                                                'autoclose'=>true,
//                                                'todayHighlight' => true,
//                                                'format' => 'yyyy-mm-dd'
//                                            ]
//                                        ])->hint( Yii::t('app', 'On this date, the ad will be hidden from the gallery')); ?>
<!--                                    </div>-->
<!--                                    <div class="clearfix"></div> -->
<!--                                    --><?php //$modelHousing->isNewRecord ? $modelHousing->ad_status=1:$modelHousing->ad_status;?>
<!--                                    <div class='col-sm-6'>-->
<!--                                        --><?php //= $form->field($modelHousing, "[{$i}]ad_status")->radioList(Yii::$app->params['statusCase'][Yii::$app->language]) ?>
<!--                                        -->
<!--                                    </div>-->
    							</div>

                            </fieldset>	
    						<fieldset>
    		                    <div class="col-sm-12">	

    								<div class='col-sm-12'>
                                        <?= $form->field($modelHousing, "[{$i}]detail")->widget(Redactor::class, [
                                            // 'options'=>['rows' => 6],
                                            'clientOptions' => [
                                                'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                                                'lang' => Yii::$app->language,
                                                'buttons'=>false,
                                            ]
                                            ])?>
                                    </div>
    							</div>
                            </fieldset>	
                            
								
                            <fieldset>
                                <div class='col-sm-4'><?= $form->field($modelHousing, "[{$i}]for_rent")->checkbox(['value'=>1]) ?></div>
                                <div class='col-sm-4'><?= $form->field($modelHousing, "[{$i}]for_sale")->checkbox(['value'=>1]) ?></div>
                                <div class='col-sm-4'><?= $form->field($modelHousing, "[{$i}]for_invest")->checkbox(['value'=>1]) ?></div>
                                <div class='col-sm-4'><?= $form->field($modelHousing, "[{$i}]rent_price")->textInput() ?></div>
                                <div class='col-sm-4'><?= $form->field($modelHousing, "[{$i}]sale_price")->textInput(['maxlength' => true]) ?></div>
                                <div class='col-sm-4'><?= $form->field($modelHousing, "[{$i}]invest_price")->textInput(['maxlength' => true]) ?></div>
								    
                                <div class='col-sm-12 label-info'><label class='label-info'><?= Yii::t('app','You can add unit images via the Units option from the main menu')?></label></div>
                            </fieldset>	
                        </div><!-- .row -->
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php DynamicFormWidget::end(); ?>
    </div>
</div>