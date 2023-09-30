<?php

use yii\helpers\Html;

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ContactTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contact Types');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-type-index  box box-primary">

    <?php if(yii::$app->user->can('/contact-type/create')){ ?>
        <div class="box-header with-border">
          <?= Html::a(Yii::t('app', 'Create Contact Type'), ['create'], ['class' => 'btn btn-success']) ?>
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
            'sort_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => yii::$app->user->can('/contact-type/delete')? '{view} {update} {delete} ' : (yii::$app->user->can('/contact-type/update')? '{view} {update}' : (yii::$app->user->can('/contact-type/view')? '{view}' : ''))
            ],
        ],
    ]); ?>

    </div>
</div>
