<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Contract;
use yii\widgets\Pjax;
use kartik\grid\GridView;

$EOS = yii::$app->SiteSetting->queryEOS();

/* @var $this yii\web\View */
/* @var $searchModel common\models\RenterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Renters');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="renter-index box box-primary">
    <?php Pjax::begin(); ?>
    <div class="box-header with-border">
        <?= Html::a(Yii::t('app', 'Create Renter'), ['create'], ['class' => 'btn btn-success btn-flat']) ?>

    </div>
    <?=Yii::$app->view->renderFile('@backend/views/layouts/_filter_date.php',['model'=>$searchModel,'label'=>yii::t('app','Created At')]);?>
    
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
                [       
                    'attribute' => 'identity_id',
                    'label' => Yii::t('app','Identity Id'),
                    
                ],
                'mobile',
                [       
                    'attribute' => 'identityType._name',
                    'label' => Yii::t('app','Identity Type'),
                    
                ],
                'created_at:date',
                [       
                    'attribute' => 'status',
                    'filter' => Yii::$app->params['statusAccount'][Yii::$app->language],
                    'value'=> function($model) {
                           return Yii::$app->params['statusAccount'][Yii::$app->language][$model->status];
                       }
                ],
                [       
                    'attribute' => 'black_list',
                    'label' => Yii::t('app','Black List'),
                    'filter' => Yii::$app->params['yesNo'][Yii::$app->language],
                    'value'=> function($model) {
                           return Yii::$app->params['yesNo'][Yii::$app->language][$model->black_list];
                       }
                ],
                [
                    'attribute' =>'nationality_id',
                    'filter'=> ArrayHelper::map($EOS['nationalities']->all(),'id','_name'),
                    'value'=> 'nationality._name',
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'options' => ['prompt' => ''],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'width'=>'100px'
                        ],
                    ],
                ],
//                [
//                   'label'=>yii::t('app','Number').' '.yii::t('app','Contracts'),
//                    'value'=> function($model) {
//                        $contract = Contract::find()->where(['renter_id'=>$model->id])->count();
//                           return $contract;
//                       }
//                ],
                // 'username',
                // 'description',
                // 'status',
                ['class' => 'yii\grid\ActionColumn',
                    'template' => (yii::$app->user->can('/renter/update'))? '{update}' :'' ,
                ],
            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>
</div>
