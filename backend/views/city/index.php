<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\VolCitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cities');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vol-city-index  box box-primary">

    <?php Pjax::begin(); ?>
    <div class="box-header with-border">
      <?= Html::a(Yii::t('app', 'Create City'), ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="box-body table-responsive"> 
      <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'name_en',
            [
               'attribute'=>'status',
               'label'=>yii::t('app','Status'),
               'filter'=> Yii::$app->params['statusCase'][Yii::$app->language],
               'value'=> function($model) {
                       return Yii::$app->params['statusCase'][Yii::$app->language][$model->status];
                   }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
    <?php Pjax::end(); ?>
</div>
