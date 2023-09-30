<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\BankAccountOfficeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Bank Account Offices');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bank-account-office-index box box-primary">
    <?php Pjax::begin(); ?>
    <div class="box-header with-border">
        <?= Html::a(Yii::t('app', 'Create Bank Account Office'), ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <div class="box-body table-responsive">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{summary}\n{items}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                //'estate_office_id',
                'bank_name',
                'bank_name_en',
				[
				   'attribute'=>'status',
				   'filter'=> Yii::$app->params['statusCase'][Yii::$app->language],
				   'label'=>yii::t('app','Status'),
				   'value'=> function($model) {
						   return Yii::$app->params['statusCase'][Yii::$app->language][$model->status];
					   }
				],
                //'logo',
                // 'account_number',
                // 'owner_account_name',
                // 'owner_account_name_en',
                // 'iban',
                // 'status',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>
</div>
