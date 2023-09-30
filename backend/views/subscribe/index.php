<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SubscribeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Subscribers Order');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscribe-index box box-primary">
    
    <div class="box-body table-responsive">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{summary}\n{items}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'name',
                'email:email',
                'mobile',
				 [
                   'attribute'=>'compony_type',
                   'filter'=> Yii::$app->params['company_type'][Yii::$app->language],
                   //'label'=>yii::t('app','Status'),
                   'value'=> function($model) {
                           return Yii::$app->params['company_type'][Yii::$app->language][$model->compony_type];
                       }
                ],
                // 'compony_name',
                // 'message:ntext',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
