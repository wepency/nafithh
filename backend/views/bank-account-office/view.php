<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\BankAccountOffice */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bank Account Offices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bank-account-office-view box box-primary">
    <div class="box-header">
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                //'estate_office_id',
                'bank_name',
                'bank_name_en',
                'account_number',
                'iban',
                'owner_account_name',
                'owner_account_name_en',
                [
				   'attribute'=>'status',
				   'filter'=> Yii::$app->params['statusCase'][Yii::$app->language],
				   'label'=>yii::t('app','Status'),
				   'value'=> function($model) {
						   return Yii::$app->params['statusCase'][Yii::$app->language][$model->status];
					   }
				],
                [
                    'format' => 'html',
                    'attribute'=>'logo',
                    'value' => function ($model) {
                        return Html::img($model->logo,
                            ['width' => '100px']);
                    },
                ],
                // 'logo',
            ],
        ]) ?>
    </div>
</div>
