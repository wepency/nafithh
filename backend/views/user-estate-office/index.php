<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
$EOS = yii::$app->SiteSetting->queryEOS();

/* @var $this yii\web\View */
/* @var $searchModel common\models\OwnerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="owner-index box box-primary">
    <?php Pjax::begin(); ?>
    <div class="box-header with-border">
        <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <div class="box-body table-responsive">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{summary}\n{items}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                [       
                    'attribute' => 'identity_id',
                    'label' => Yii::t('app','Identity Id'),
                    
                ],
                [       
                    'attribute' => 'identityType._name',
                    'label' => Yii::t('app','Identity Type'),
                    
                ],
                [       
                    'attribute' => 'status',
                    'filter' => Yii::$app->params['statusAccount'][Yii::$app->language],
                    'value'=> function($model) {
                           return Yii::$app->params['statusAccount'][Yii::$app->language][$model->status];
                       }
                ],
                [
                   'attribute'=>'nationality_id',
                    'filter'=> ArrayHelper::map($EOS['nationalities']->all(),'id','_name'),
                   'value'=> 'nationality._name'
                ],
                'name',
                'username',
                // 'description',
                // 'status',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>
</div>
