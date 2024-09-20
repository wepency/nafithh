<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor;

/* @var $this yii\web\View */
/* @var $model common\models\OrderMaintenance */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-maintenance-form box box-primary">

    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>

     <div class="box-body table-responsive">

        <?=Yii::$app->view->renderFile('@backend/views/order-info/_order-info.php',['model'=>$model->orderInfo]);?>

		<fieldset>
            <div class='col-sm-12'>

				<?php $user = Yii::$app->user->identity;
                echo Html::activeHiddenInput($model, "status");

                if($flag = in_array($user->user_type, ['maintenance_officer','maintenance_officer_user'])){?>
                    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Price')?></label>
                    <div class='col-sm-4'>
                    <?php echo ($model->status < 3)? $form->field($model, 'price')->textInput()->label(false)->hint(yii::t('app','You cannot change the price after the Order is Accepted')):"<label class='label-data'>$model->price</label>" ?>
                    </div>

                    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Note')?></label>
                    <div class='col-sm-4'>
                        <?= $form->field($model, 'note')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                            'lang' => Yii::$app->language,
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
                    </div> 

                    <div class='clearfix'></div>
                    <div class='space_v'></div>

                    <?php if($model->reason_disagree){?>
                        <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Reason Disagree')?></label>
                        <div class='col-sm-10'>
                            <label class="label-data"><?=$model->reason_disagree?></label>
                        </div>
                    <?php } ?>
                    <div class='clearfix'></div>
                    
                    <label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Attachments After Fix') ?> </label>
                    <div class='col-sm-10'>
                        <?= \common\components\MultiAttachmentWidget::widget(['model'=>$model,'form'=>$form,'files'=>$arrImages2])?>
                    </div>

                <?php }else{ ?>

                    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Price')?></label>
                    <div class='col-sm-4'>
                        <label class="label-data"><?=$model->price?></label>
                    </div>

                    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Note')?></label>
                    <div class='col-sm-4'>
                        <label class="label-data"><?=$model->note?></label>
                    </div>

                    <div class='clearfix'></div>
                    <div class='space_v'></div>

                    <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Reason Disagree')?></label>

                    <div class='col-sm-10'>
                        <?= $form->field($model, 'reason_disagree')->widget(Redactor::class, [
                        'clientOptions' => [
                            'direction'=>Yii::$app->language=='ar'?'rtl':'ltr',
                            'lang' => Yii::$app->language,
                            'plugins' => ['clips', 'fontcolor','imagemanager','counter','definedlinks','filemanager','fontcolor','fontfamily','fontsize','fullscreen','limiter','table','textdirection','textexpander']

                        ]
                        ])->label(false)?>
                    </div>

                <?php } ?>


                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Status')?></label>
                <div class='col-sm-4'>
                    <label class="label-data"><?=Yii::$app->params['statusOrder'][Yii::$app->language][$model->status]?></label>
                </div>

                <div class='clearfix'></div>


                

			</div>
		</fieldset>
	</div>
	
    <div class="box-footer">
    <?php
            if($flag && in_array($model->status, [2,5,6,7])){
                    // echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
                        echo "  ";
                switch ($model->status) {
                    case 2:
                        echo Html::Submitbutton(Yii::$app->params['statusOrder'][Yii::$app->language][3],  [
                            'class' => 'btn btn-info',
                            'onclick' => "console.log($('input[name=\"OrderMaintenance[status]\"]').val(3))",
                            ]);
                        echo "  ";
                        echo Html::a(Yii::$app->params['statusOrder'][Yii::$app->language][4],['change-status','order_id' => $model->id,'status'=>4], ['class' => 'btn btn-danger','data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to').' '.Yii::$app->params['statusOrder'][Yii::$app->language][4].'?',
                                'method' => 'post',
                            ]]);
                        break;
                    case 5:
                    case 6:
                        echo Html::a(Yii::$app->params['statusOrder'][Yii::$app->language][7],['change-status','order_id' => $model->id,'status'=>7], ['class' => 'btn btn-info','data' => ['method' => 'post']]);
                        break;
                    case 7:
                            echo Html::Submitbutton(Yii::$app->params['statusOrder'][Yii::$app->language][8],  [
                            'class' => 'btn btn-info',
                            'onclick' => "console.log($('input[name=\"OrderMaintenance[status]\"]').val(8))",
                            ]);
                        break;
                    default:
                        break;
                }
            }elseif(!$flag && in_array($model->status, [3,4,8])){
                switch ($model->status) {
                    case 3:
                         echo Html::a(Yii::$app->params['statusOrder'][Yii::$app->language][5],['change-status','order_id' => $model->id,'status'=>5], ['class' => 'btn btn-info','data' => ['method' => 'post']]);
                        break;
                    case 4:
                        echo Html::a(Yii::$app->params['statusOrder'][Yii::$app->language][10],['change-status','order_id' => $model->id,'status'=>10], ['class' => 'btn btn-danger','data' => ['method' => 'post']]);
                        break;
                    case 8:
                        echo Html::a(Yii::$app->params['statusOrder'][Yii::$app->language][9],['change-status','order_id' => $model->id,'status'=>9], ['class' => 'btn btn-info','data' => ['method' => 'post']]);
                        echo "  ";
                        echo Html::a(Yii::$app->params['statusOrder'][Yii::$app->language][6],['change-status','order_id' => $model->id,'status'=>6], ['class' => 'btn btn-info','data' => ['method' => 'post']]);
                        break;
                    case 9:
                        echo Html::a(Yii::$app->params['statusOrder'][Yii::$app->language][10],['change-status','order_id' => $model->id,'status'=>10], ['class' => 'btn btn-danger','data' => ['method' => 'post']]);
                        break;
                    default:
                        break;
                }

            }
        ?>
    </div>
    

    <?php ActiveForm::end(); ?>

</div>
