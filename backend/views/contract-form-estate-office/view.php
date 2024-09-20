<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ContractFormEstateOffice */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contract Form Estate Offices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="contract-form-estate-office-view box box-primary">

    <div class="box-header">
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <div class="box-body table-responsive">
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'id',
            // 'estate_office_id',
            // 'contract_form_id',
            'contract_form_name',
            'contract_form_name_en',
             [
                'format' => 'html',
                'attribute' =>'contract_form_text',
            ],
             [
                'format' => 'html',
                'attribute' =>'contract_form_text_en',
            ],
            // 'contract_form_text:ntext',
            // 'contract_form_text_en:ntext',
            // [
            //    'attribute'=>'status',
            //    'label'=>yii::t('app','Status'),
            //    'value'=> function($model) {
            //            return Yii::$app->params['statusCase'][Yii::$app->language][$model->status];
            //        }
            // ], 
            // 'status',
        ],
    ]) ?>
    </div>
</div>
