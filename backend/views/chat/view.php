<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use yii\widgets\ActiveForm;
$this->registerCssFile("@web/css/yiiSimpleChat.css");

/* @var $this yii\web\View */
/* @var $model common\models\Chat */
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Chats'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="chat-view box box-primary">
    <div class="box-body table-responsive">
        <fieldset>
            <div class='col-sm-12'>
                 <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Sender')?></label>
                <div class='col-sm-4'>
                    <label class='label-data'><?= ($model->getChatHistories()->first() ===null)? 
                    $model->sender['type'].': '.(isset($model->sender['office_name'])? $model->sender['office_name'] : '') :
                      $model->getChatHistories()->first()->senderName() ?></label>
                </div>
                <label for='' class='col-sm-2 control-label'><?=Yii::t('app', 'Receiver')?></label>
                <div class='col-sm-4'>
                    <label class='label-data'><?= $model->receiver['type'].': '. (isset($model->receiver['office_name'])? $model->receiver['office_name'].': ' : '').(isset($model->receiver['user_data']->name)? ' ('.$model->receiver['user_data']->name.')' : '') ?></label>
                </div>
            </div>
        </fieldset>
        <div id="messenger" class="message-wrap " bis_skin_checked="1">
            <div id="msg-container" class="msg-wrap" bis_skin_checked="1">
                <div id="messages-loader" style="display: none" class="text-center" bis_skin_checked="1">
                    <img alt="Loading..." src="<?=yii::$app->homeUrl?>/../images/inf-circle-loader.gif">
                </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
                <?php foreach ($model->chatHistories as $chat) {
                 /*print_r($chat->user->avatar); die();*/ ?>

                <div class="media msg">
                    <a class="pull-left">
                        <img class="media-object"  alt="<?=$chat->senderName()?>" style="width: 32px; height: 32px;" src="<?=$chat->image()?>"/>
                    </a>
                    <div class="media-body">
                        <small class="pull-right time"><i class="fa fa-clock-o"></i> <?=$chat->date()?></small>
                        <h5 class="media-heading"><?=$chat->senderName()?></h5>
                        <small class="col-lg-10"><?=$chat->message?></small>
                    </div>
                </div>
                <?php } ?>

            </div>
            <?php $form = ActiveForm::begin([]); ?>
                <div class="send-wrap " bis_skin_checked="1">
                    <?= $form->field($modelhistory, 'message')->textarea(['class'=> 'form-control send-message','rows' => 6,'placeholder'=>yii::t('app','Write a reply...')])->label(false) ?>
                </div>
                <div class="" bis_skin_checked="1">
                    <?= Html::submitButton("<i class='fa fa-location-arrow'></i>".Yii::t('app', 'Send Message'), ['class' =>'col-lg-4 text-right btn btn-primary  send-message-btn pull-left','template']) ?>
                </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>

