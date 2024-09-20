<?php

use yii\helpers\Html;

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PlanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Plans');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-index  box box-primary">

        <div class="box-header with-border">
          <?= Html::a(Yii::t('app', 'Create Plan'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    <div class="box-body table-responsive"> 
      <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'title_en',
            [
                'format' => 'html',
                'attribute'=>'image',
                'value' => function ($model) {
                    return Html::img($model->image,['width' => '150px']);
                },
            ],
            //'price',
            [
               'attribute'=>'status',
               'filter'=> Yii::$app->params['statusCase'][Yii::$app->language],
               'value'=> function($model) {
                    return Yii::$app->params['statusCase'][Yii::$app->language][$model->status];
                }
            ],
            [
               'attribute'=>'period',
               'filter'=> Yii::$app->params['period'][Yii::$app->language],
               'value'=> function($model) {
                    return Yii::$app->params['period'][Yii::$app->language][$model->period];
                }
            ],
            [
               'attribute'=>'currency',
               'filter'=> Yii::$app->params['currency'][Yii::$app->language],
               'value'=> function($model) {
                    return Yii::$app->params['currency'][Yii::$app->language][$model->currency];
                }
            ],
            [
               'attribute'=>yii::t('app','Count Features'),
               'value'=> function($model) {
                    return $model->getPlanItems()->count()?? 0;
                }
            ],
            [
                'label'=> yii::t('app','Count Orders'),
               'value'=> function($model) {
                    return $model->getOrders()->count()?? 0;
                }
            ],
            //'created_date',
            //'views',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => yii::$app->user->can('/plan/delete')? '{view} {update} {delete} ' : (yii::$app->user->can('/plan/update')? '{view} {update}' : (yii::$app->user->can('/plan/view')? '{view}' : ''))
            ],
        ],
    ]); ?>

    </div>
</div>
