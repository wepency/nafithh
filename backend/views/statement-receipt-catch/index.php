<?php

use common\models\StatementReceiptCatch;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
// use yii\grid\GridView;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\StatementReceiptCatchSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Statement Receipt Catches');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-index box box-primary">
<?=Yii::$app->view->renderFile('@backend/views/layouts/_filter_date.php',['model'=>$searchModel,'label'=>yii::t('app','Created Date')]);?>

    <div class="box-body table-responsive">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showPageSummary' => true,
        
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'amount_paid',
                'pageSummary' =>true,
            ],
            // 'amount_paid',
            [
                'attribute' =>'estate_office_name',
                'label' =>yii::t('app','Estate Office'),
                'value'=> 'estateOffice.name'
            ],
            [
                'attribute'=>'owner_name',
                'label'=>yii::t('app','Owner Name'),
                'value'=> 'owner.name',
            ],
            // [
            //     'label' =>yii::t('app','Owner Name'),
            //     'attribute' =>'owner_id',
            //     'value'=> 'owner.name'
            // ],
            // 'estate_office_id',
            // 'owner_id',
            'detail:ntext',
            //'detail_en:ntext',
            'created_date',
            [
                'class' => ActionColumn::class,
                'template'=>'{view}',
                'urlCreator' => function ($action, StatementReceiptCatch $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


    </div>
</div>
