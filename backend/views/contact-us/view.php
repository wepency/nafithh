<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ContactUs */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contact uses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="contact-us-view box box-primary">

    <div class="box-header">

        <?php if(yii::$app->user->can('/contact-us/delete')){ ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        <?php } ?> 
    </div>

    <div class="box-body table-responsive">
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'id',
            'name',
            'email:email',
            'mobile',
            'title',
            [
                'format' => 'html',
                'attribute' =>'msg',
            ],
            'created_at',
            [
                'format' => 'html',
                'attribute' =>'replay_msg',
            ],
            'user.name',
            [
               'attribute'=>'status',
               'value'=> function($model) {
                    return Yii::$app->params['statusRead'][Yii::$app->language][$model->status];
                }
            ],
            [
                'attribute'=>'contact_type_id',
                'value'=> function($model) {
                    return $model->contactType->_title;
                }
            ],
            [
                'format'=>'raw',
                'label'=>yii::t('app','Attachments'),
                'value'=> function($model) {
                    $attWidget =  new \common\components\MultiAttachmentWidget(['model'=>$model]);
                    return $attWidget->runForView();
                }
            ],
        ],
    ]) ?>
    </div>
</div>

<div class="box-body table-responsive box box-success">
    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>
        <label for='' class='col-sm-1 control-label'><?= Yii::t('app', 'Replay Msg') ?> </label> 
        <div class='col-sm-11'><?= $form->field($model, 'replay_msg')->textarea(['rows' => 6])->label(false) ?></div>
        <div class="box-footer">
            <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-success btn-flat']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>
