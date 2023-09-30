<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
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
                   'attribute'=>'nationality_id',
                    'filter'=> ArrayHelper::map($EOS['nationalities']->all(),'id','_name'),
                   'value'=> 'nationality._name'
                ],
                [

                    'label' => Yii::t('app', 'Statement Owner'),
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'text-align: center;'],
                    'value'=> function($models) {
                        // if(!$models->isPaid()){
                            return Html::a('<span class="fa fa-bar-chart-o" aria-hidden="true"></span>',
                                ['/statement/index',
                                    'owner_id' => $models->id,
                                ],
                                ['class' => 'btn btn-reddit','data-pjax'=>0]
                            );
                        // };
                        return '';
                    },
                    'visible' => yii::$app->user->can('/statement/index'),
                ],
                // 'username',
                // 'description',
                // 'status',
                ['class' => 'yii\grid\ActionColumn',
                    'template' => (yii::$app->user->can('/user/update'))? '{update}{view}' :'' ,
                ],
            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>
</div>
