<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="order-view box box-primary">

    <div class="box-header">
        <?php /* if(yii::$app->user->can('/order/update')){ ?>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php } */?> 
  

        <?php if(yii::$app->user->can('/order/delete')){ ?>
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
            // [
            //     'format' => 'html',
            //     'attribute' =>'content',
            // ],
            'mobile',
            'email:email',
            'company_name',
            [
                'attribute' => 'plan_id',
                'format' => 'raw',
                'value'=> function($model) {
                    return Html::a($model->plan->_title.'  &nbsp;'.Html::tag('i',null,['class'=>'fa fa-share-square-o']),Yii::$app->homeUrl.'plan/'.$model->plan->id,['style'=>'color:#3c8dbc!important;']);
                }
            ],
            [
               'attribute'=>'status',
               'value'=> function($model) {
                    return Yii::$app->params['statusRead'][Yii::$app->language][$model->status];
                }
            ],
            // [
            //    'attribute'=>'payment_status',
            //    'value'=> function($model) {
            //         return Yii::$app->params['statusPayment'][Yii::$app->language][$model->payment_status];
            //     }
            // ],
             [
               'attribute'=>'company_type',
               'value'=> function($model) {
                    return Yii::$app->params['company_type'][Yii::$app->language][$model->company_type];
                }
            ],
            [
               'attribute'=>'detail_field.sender_name',
               'label'=> yii::t('app','Sender Name'),
            ],
            [
               'attribute'=>'detail_field.amount',
               'label'=> yii::t('app','Amount'),
            ],
            'created_date',
            [
               'attribute'=>'response_by',
               'value'=> function($model) {
                    return $model->responseBy->name;
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
