<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use common\models\City;
use yii\helpers\ArrayHelper;



/* @var $this yii\web\View */
/* @var $searchModel common\models\VolDistrictSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Districts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vol-district-index  box box-primary">

    <?php Pjax::begin(); ?>
    <div class="box-header with-border">
      <?= Html::a(Yii::t('app', 'Create District'), ['create'], ['class' => 'btn btn-success']) ?>
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
                'attribute' =>'city_id',
                'filter'=> ArrayHelper::map(City::find()->where(['>','id',0])->all(),'id','_name'),
                'value'=> 'city._name'
            ],
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
