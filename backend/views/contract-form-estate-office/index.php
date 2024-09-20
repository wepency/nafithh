<?php

use yii\helpers\Html;

use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ContractFormEstateOfficeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contract Form Estate Offices');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contract-form-estate-office-index  box box-primary">

    <?php Pjax::begin(); ?>

    <div class="box-header with-border">
      <?= Html::a(Yii::t('app', 'Create Contract Form Estate Office'), ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="box-body table-responsive"> 
      <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            // 'estate_office_id',
            // 'contract_form_id',
            'contract_form_name',
            'contract_form_name_en',
            //'contract_form_text:ntext',
            //'contract_form_text_en:ntext',
            //'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
    <?php Pjax::end(); ?>
</div>
