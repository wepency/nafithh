<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\Plan;

use yii\grid\GridView;
use common\widgets\Chart;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Subscriptions');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-3">
        <?php echo Chart::card([
            'content' => \common\components\GeneralHelpers::getAvailableBalance(),
            'label' => yii::t('app', 'Contracts balance'),
            'color' => 'bg-yellow-active', 'icon' => 'fa fa-sticky-note',
            'url' => Yii::$app->homeUrl . 'contract/create',

        ]); ?>
    </div>

    <div class="col-md-3">
        <?php echo Chart::card([
            'content' => \common\components\GeneralHelpers::getAvailableBalance('sms'),
            'label' => yii::t('app', 'SMS balance'),
            'color' => 'small-box bg-teal', 'icon' => 'fa fa-area-chart',
            'url' => Yii::$app->homeUrl . 'subscriptions',

        ]); ?>
    </div>

    <!--    <div class="col-md-3">-->
    <!--        --><?php //echo Chart::card([
    //            'content' => $countContractOpen,
    //            'label' => yii::t('app','Number').' '.yii::t('app',"Opened Contracts"),
    //            'color' => 'bg-aqua', 'icon' => 'fa fa-area-chart',
    //            'url' =>Yii::$app->homeUrl.'contract?ContractSearch[is_active]=1' ,
    //
    //        ]);?>
    <!--    </div>-->

    <!--    <div class="col-md-3">-->
    <!--        --><?php //echo Chart::card([
    //            'content' => $countContractClose,
    //            'label' => yii::t('app','Number').' '.yii::t('app',"Closed Contracts"),
    //            'color' => 'bg-green', 'icon' => 'fa fa-area-chart',
    //            'url' =>Yii::$app->homeUrl.'contract?ContractSearch[is_active]=0' ,
    //
    //        ]);?>
    <!--    </div>-->

</div>

<div class="order-index  box box-primary">

    <?php /* if(yii::$app->user->can('/order/create')){ ?>
        <div class="box-header with-border">
          <?= Html::a(Yii::t('app', 'Create Order'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    <?php }*/ ?>
    <div class="box-body table-responsive">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'rowOptions' => function ($model) {
                if ($model->status == 0) {
                    return ['class' => 'danger'];
                }

                return ['class' => 'success'];
            },
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'code',
                    'label' => 'كود الاشتراك'
                ],
                [
                    'attribute' => 'plan_id',
                    'format' => 'raw',
                    'filter' => ArrayHelper::map(Plan::find()->all(), 'id', '_title'),
                    'value' => function ($model) {
                        return Html::a($model->plan?->_title . '  &nbsp;' . Html::tag('i', null, ['class' => 'fa fa-share-square-o']), Yii::$app->homeUrl . 'plan/' . $model->plan?->id, ['style' => 'color:#3c8dbc!important;']);
                    }
                ],
                [
                    'attribute' => 'total',
                    'format' => 'raw',
                    'filter' => ArrayHelper::map(Plan::find()->all(), 'id', 'total'),
                    'value' => function ($model) {
                        return $model->total . ' ريال';
                    }
                ],
                [
                    'attribute' => 'status',
                    'filter' => Yii::$app->params['statusRead'][Yii::$app->language],
                    'value' => function ($model) {
                        return Yii::$app->params['statusRead'][Yii::$app->language][$model->status];
                    }
                ],
                'created_date',
                [
                    'attribute' => 'created_date',
                    'label' => 'تاريخ الإنتهاء',
                    'value' => function ($model) {
                        // Convert the created_date attribute to a DateTime object
                        $date = new DateTime($model->created_date);

                        // Add one year to the date
                        $date->modify('+1 year');

                        // Format the date as desired (e.g., 'Y-m-d H:i:s' for year-month-day hour:minute:second)
                        return $date->format('Y-m-d');
                    }
                ]
            ],
        ]); ?>

    </div>
</div>
