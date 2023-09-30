<?php

use yii\helpers\Html;
use common\models\MaintenanceType;
use common\models\OrderMaintenanceSearch;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Order Maintenances');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-info-index  box box-primary">
    
    <div class="box-body table-responsive"> 
      <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?=Yii::$app->view->renderFile('@backend/views/layouts/_filter_date.php',['model'=>$searchModel,'label'=>yii::t('app','Created Date')]);?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
          'after'=>''
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                    'value' => function($model, $key, $index, $column){
                      if ($model->orderMaintenances) {
                            return GridView::ROW_COLLAPSED;
                        }
                },
                'detail' => function($model, $key, $index, $column){
                    $searchModel = new OrderMaintenanceSearch();               
                    $searchModel->order_info_id = $model->id;
                    //$searchModel-> total = $model->total;
                    //$searchModel-> manager = $model->manager;
                    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                    return Yii::$app->controller->renderPartial('@backend/views/order-maintenance/index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                    ]);                   
                },
            ],
            'id',
            'title',
            [
               'attribute'=>'maintenance_type_id',
                'filter'=> ArrayHelper::map(MaintenanceType::find()->where(['>','id',0])->all(),'id','_name'),
               'value'=> 'maintenanceType._name'
            ],
            // [
            //    'attribute'=>'estate_office_id',
            //     'filter'=> false,
            //    'value'=> 'estateOffice._name'
            // ],
            [
               'attribute'=>'buildingHousingUnit.building.building_name',
                'filter'=> false,
               'value'=> 'buildingHousingUnit.building.building_name'
            ],
            [
               'attribute'=>'building_housing_unit_id',
                'filter'=> false,
               'value'=> 'buildingHousingUnit.housing_unit_name'
            ],
            [
               'attribute'=>'sender_id',
                'filter'=> false,
                'value'=> function($model) {
                  return Yii::$app->params['userType'][Yii::$app->language][$model->sender_type].' - '.
                    $model->sender->name;
                }
            ],
            [
               'attribute'=>'send_to',
                'filter'=> false,
                'value'=> function($model) {
                  return Yii::$app->params['userType'][Yii::$app->language][$model->send_to];
                }
            ],
            // 'sender_type',
            // 'send_to',
            [
               'attribute'=>'is_draft',
               'filter'=> Yii::$app->params['yesNo'][Yii::$app->language],
               'label'=>yii::t('app','Is Draft'),
               'value'=> function($model) {
                       return Yii::$app->params['yesNo'][Yii::$app->language][$model->is_draft];
                   }
            ],
            //'details_order:ntext',
            'created_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
