<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\OrderMaintenance */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Order Maintenances'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="order-maintenance-view box box-primary">


    <div class="box-body table-responsive">
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'id',
            [
               'attribute'=>'maintenance_office_id',
               'value'=> function($model) {
                       return $model->maintenanceOffice->name;
                   }
            ],
            // 'order_info_id',
            'note:ntext',
            'price',
             [
               'attribute'=>'status_accept',
               'value'=> function($model) {
                       return Yii::$app->params['yesNo'][Yii::$app->language][$model->status_accept];
                   }
            ],
            [
               'attribute'=>'status',
               'value'=> function($model) {
                       return Yii::$app->params['statusOrder'][Yii::$app->language][$model->status];
                   }
            ],
            // 'order_info_id',
             [
                'format' => 'html',
                'attribute' =>'note',
            ],
            'price',
            [
                'format'=>'raw',
                'label'=>yii::t('app','Attachments Before Fix'),
                'value'=> function($model) {
                    $attWidget =  new \common\components\MultiAttachmentWidget(['model'=>$model->orderInfo]);
                    return $attWidget->runForView();
                }
            ],
            [
                'format'=>'raw',
                'label'=>yii::t('app','Attachments After Fix'),
                'value'=> function($model) {
                    $attWidget =  new \common\components\MultiAttachmentWidget(['model'=>$model]);
                    return $attWidget->runForView();
                }
            ],
            // 'status',
            // 'status_accept',
            [
                'format' => 'html',
                'attribute' =>'reason_disagree',
            ],
        ],
    ]) ?>
    </div>
</div>
