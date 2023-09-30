<?php

use yii\helpers\Html;

use johnitvn\ajaxcrud\BulkButtonWidget;
use kartik\grid\GridView;
use common\models\MaintenanceOffice;

use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\MaintenanceInvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Maintenance Invoices');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="maintenance-invoice-index  box box-primary">


    <?php if(yii::$app->user->can('/maintenance-invoice/create')){ ?>
    <div class="box-header with-border">
        <?= Html::a(Yii::t('app', 'Create Maintenance Invoice'), ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <?php } ?>
    <?=Yii::$app->view->renderFile('@backend/views/layouts/_filter_date.php',['model'=>$searchModel,'label' => Yii::t('app', 'Created At')]);?>

    <div class="box-body table-responsive"> 
      <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
          'after'=>''
        ],
        'rowOptions' => function ($model) {
            if($model->payment_status == 0){
                return ['class' => 'table-warning'];
            }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute'=>'office_id',
                'filter'=> ArrayHelper::map(MaintenanceOffice::find()->where(['>','id',0])->all(),'id','name'),
                'value'=> function($model) {
                       return $model->office->name;
                   },
                'visible' => yii::$app->user->can('/maintenance-invoice/create'),

            ],
            'date_from',
            'date_to',
            'total_amount',
            'commission_percent',
            'commission_amount',
            [
               'attribute'=>'payment_status',
               'filter'=> Yii::$app->params['yesNo'][Yii::$app->language],
               'value'=> function($model) {
                       return Yii::$app->params['yesNo'][Yii::$app->language][$model->payment_status];
                   }
            ],
            //'office_earnings',
            //'office_id',
            'userCreated.name',
            //'payment_status',
            'created_at',
            [
                // 'label' => yii::t('app','الدفع'),
                'format' => 'raw',
                'value'=> function($model) {
                    if($model->payment_status == 0){
                        return Html::a(Yii::t('app', 'Paid'),['paid','id' => $model->id],[
                            'class' => 'btn btn-success',
                            'title'=>yii::t('app','if invoice paid click here'),   
                            'data' => [
                                    'confirm' => Yii::t('app', 'Are you sure you want to paid it Invoice?'),
                                    'method' => 'post',
                            ]
                        ]);
                    }
                },
                'visible' => yii::$app->user->can('/maintenance-invoice/paid'),
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template' => (yii::$app->user->can('/maintenance-invoice/create'))? '{view} {update}' :'{view} ' ,
            ],
        ],
    ]); ?>

    </div>
</div>
