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

$this->title = Yii::t('app', 'Estate Office');
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
                'auth_person',
                [       
                    'attribute' => 'identity_id',
                    'label' => Yii::t('app','Identity Id'),
                    
                ],
                'mobile',
                [

                    'label' => Yii::t('app', 'Statement Owner'),
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'text-align: center;'],
                    'value'=> function($models) {
                        // if(!$models->isPaid()){
                            return Html::a('<span class="fa fa-bar-chart-o" aria-hidden="true"></span>',
                                ['/statement/office',
                                    'estate_office_id' => $models->id,
                                ],
                                ['class' => 'btn btn-reddit','data-pjax'=>0]
                            );
                        // };
                        return '';
                    },
                    'visible' => yii::$app->user->can('/statement/office'),
                ],
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '' ,
                ],
            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>
</div>
