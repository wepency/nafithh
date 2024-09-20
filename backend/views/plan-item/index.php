<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PlanItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Plan Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-item-index  box box-primary">

    <?php if(yii::$app->user->can('/plan-item/create')){ ?>
        <div class="box-header with-border">
          <?= Html::a(Yii::t('app', 'Create Plan Item'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    <?php } ?> 
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
                'attribute' => 'plan_id',
                'filter'=> ArrayHelper::map(\common\models\Plan::find()->all(),'id','_title'),
                'value' => 'plan._title'
            ],
            'sort_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => yii::$app->user->can('/plan-item/delete')? '{view} {update} {delete} ' : (yii::$app->user->can('/plan-item/update')? '{view} {update}' : (yii::$app->user->can('/plan-item/view')? '{view}' : ''))
            ],
        ],
    ]); ?>

    </div>
</div>
