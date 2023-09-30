<?php
use yii\helpers\Html;
// use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use kartik\grid\GridView;

use common\models\Contract;
$EOS = yii::$app->SiteSetting->queryEOS();

/* @var $this yii\web\View */
/* @var $searchModel common\models\OwnerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Owners');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="owner-index box box-primary">
    <?php Pjax::begin(); ?>
    <div class="box-header with-border">
        <?= Html::a(Yii::t('app', 'Create Owner'), ['create'], ['class' => 'btn btn-success btn-flat']) ?>
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
                [       
                   'label'=>yii::t('app','Number').' '.yii::t('app','Contracts'),
                    'value'=> function($model) {
                        $contract = Contract::find()->where(['owner_id'=>$model->id])->count();
                           return $contract;
                       }
                ],
                [

                    'label' => Yii::t('app', 'Create Building'),
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'text-align: center;'],
                    'value'=> function($models) {
                        // if(!$models->isPaid()){
                            return Html::a('<span class="fa fa-plus-circle" aria-hidden="true"></span>',
                                ['/building/create',
                                    'owner_id' => $models->id,
                                ],
                                ['class' => 'btn btn-social-icon']
                            );
                        // };
                        return '';
                    },
                    'visible' => yii::$app->user->can('/building/create'),
                ],
                // 'username',
                // 'description',
                // 'status',
                ['class' => 'yii\grid\ActionColumn',
                    'template' => (yii::$app->user->can('/owner/update'))? '{update}' :'' ,
                ],
            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>
</div>
