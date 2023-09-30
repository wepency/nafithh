<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\StatementReceiptCatch $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Receipt Catches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="slider-view box box-primary">
    <div class="box-body table-responsive no-padding">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'amount_paid',
            [
               'attribute'=>'owner_id',
               'value'=> function($model){
                return ($model->owner)? $model->owner->name:'';
              }
            ],
            [
               'attribute'=>'estate_office_id',
               'value'=> function($model){
                return ($model->estateOffice)? $model->estateOffice->name:'';
              }
            ],
            'detail:ntext',
            'detail_en:ntext',
            'created_date',
        ],
    ]) ?>

    </div>
</div>
