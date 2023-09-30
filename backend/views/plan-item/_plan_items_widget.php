<?php
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
// print_r($attributeId); die();

// $listOptions = $model->listOptions();


?>
<div class="">
    <div class="">
         <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
            'widgetBody' => '.container-itemsHo', // required: css class selector
            'widgetItem' => '.itemHo', // required: css class
            'limit' => 100, // the maximum times, an element can be cloned (default 999)
            'min' => 1, // 0 or 1 (default 1)
            'insertButton' => '.add-itemHo', // css class
            'deleteButton' => '.remove-itemHo', // css class
            'model' => $models[0],
            'formId' => 'dynamic-form',
            'formFields' => [
                'title',
                'title_en',
                'sort_at',
            ],
        ]); ?>

        <div class="container-itemsHo"><!-- widgetContainer -->
            <?php foreach ($models as $i => $model): ?>
                <div class="itemHo panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left"><?= Yii::t('app','The Feature')."( ".$i." )"?></h3>
                        <div class="pull-right">
                            <button type="button" class="add-itemHo btn bg-green-active btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-itemHo btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
							// necessary for update action.
							//$initial = false;
						if (! $model->isNewRecord) {
							echo Html::activeHiddenInput($model, "[{$i}]id");
						}
						?>
                        <div class="row">
                            <fieldset class="no-padding no-margin">
                                <div class='col-sm-12'> 

                                    <div class='col-sm-4'>
                                    	<?= $form->field($model, "[{$i}]title")->textInput(['maxlength' => true]) ?>
                                    </div>
                                    <div class='col-sm-4'>
                                    	<?= $form->field($model, "[{$i}]title_en")->textInput(['maxlength' => true]) ?>
                                    </div>

                                    <div class='col-sm-4'>
                                       <?= $form->field($model, "[{$i}]sort_at")->textInput(['maxlength' => true,'type'=>'number']) ?>
                                            
                                    </div>
              
                                </div>
                            </fieldset> 
                        </div><!-- .row -->
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php DynamicFormWidget::end(); ?>
    </div>
</div>