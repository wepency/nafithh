<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Ads');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="ad-index box box-primary">
    <?php Pjax::begin(); ?>
    <div class="box-header with-border">
        <?= Html::a(Yii::t('app', 'Create Ad'), ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <div class="box-body table-responsive">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'name',
                'name_en',
                [
                    'format' => 'html',
                    'label' => yii::t('app','Image'),
                    'attribute'=>'image',
                    'value' => function ($model) {
                       return Html::img($model->image,['width' => '150px']);
                    },
                ],
                [
				   'attribute'=>'status',
				   'filter'=> Yii::$app->params['statusCase'][Yii::$app->language],
				   'label'=>yii::t('app','Status'),
				   'value'=> function($model) {
						   return Yii::$app->params['statusCase'][Yii::$app->language][$model->status];
					   }
				],
                [
                   'attribute'=>'page_name',
                   'filter'=> Yii::$app->params['pageName'][Yii::$app->language],
                   'value'=> function($model) {
                           return Yii::$app->params['pageName'][Yii::$app->language][$model->page_name];
                       }
                ],
                //'image',
                // 'status',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>
</div>
