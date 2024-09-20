<?php

use yii\helpers\Html;
use johnitvn\ajaxcrud\BulkButtonWidget;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SystemExpenseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'System Expenses');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-expense-index  box box-primary">


    <div class="box-header with-border">
      <?= Html::a(Yii::t('app', 'Create System Expense'), ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="box-body table-responsive"> 
      <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?=Yii::$app->view->renderFile('@backend/views/layouts/_filter_date.php',['model'=>$searchModel,'label'=>yii::t('app','Expense Date')]);?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
          'after'=>''
        ], 
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'item',
            'amount',
            [
              'attribute' =>'user_created_id',
              'filter' => false,
              'value'=> function($model){
                return $model->userCreated->name;
              }
            ],
            // 'details:ntext',
            // 'created_date',
            'pay_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
