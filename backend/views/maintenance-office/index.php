<?php

use yii\helpers\Html;

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\City;
use common\models\District;
/* @var $this yii\web\View */
/* @var $searchModel common\models\MaintenanceOfficeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Maintenance Offices');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="maintenance-office-index  box box-primary">
<div id="ajaxCrudDatatable">

    <div class="box-header with-border">
      <?= Html::a(Yii::t('app', 'Create Maintenance Office'), ['create'], ['class' => 'btn btn-success']) ?>
      
      <?=Yii::$app->view->renderFile('@backend/views/layouts/_filter_date.php',['model'=>$searchModel,'label'=>yii::t('app','Registration Date')]);?>

    </div>
    <div class="box-body table-responsive"> 
      <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'auth_person',
            'mobile',
            'registration_code',
            [
              
                'format' => 'html',
                'attribute'=>'logo',
                'value' => function ($model) {
                  return Html::img($model->logo,
                    ['width' => '100px']);
                },
            ],
            //'logo',
            [
                'attribute' =>'city_id',
                'filter'=> ArrayHelper::map(City::find()->where(['>','id',0])->all(),'id','_name'),
                'value'=> 'city._name'
            ],
            [
                'attribute' =>'district_id',
                'filter'=> ArrayHelper::map(District::find()->where(['>','id',0])->all(),'id','_name'),
                'value'=> 'district._name'
            ],
            'tax',
            'registration_date:date',
            [
               'attribute'=>'status_account',
               'label'=>yii::t('app','Status Account'),
               'filter'=> Yii::$app->params['statusAccount'][Yii::$app->language],
               'value'=> function($model) {
                       return Yii::$app->params['statusAccount'][Yii::$app->language][$model->status_account];
                   }
            ],
            [
               'label'=>yii::t('app','Number').' '.yii::t('app','Order Maintenances'),
               'value'=> function($model) {
                    $orders = \common\models\OrderMaintenance::find()->where(['maintenance_office_id' => $model->id])->all();
                       return count($orders);
                   },
                'headerOptions' => ['style' => 'width:5%'],
            ],
            [
               'label'=>yii::t('app','Number').' '.yii::t('app','Opened Orders'),
               'value'=> function($model) {
                    $orders = \common\models\OrderMaintenance::find()->where(['maintenance_office_id' => $model->id])->andWhere(['!=','status' , 10])->all();
                       return count($orders);
                   },
                'headerOptions' => ['style' => 'width:5%'],
            ],
            [
               'label'=>yii::t('app','Number').' '.yii::t('app','Closed Orders'),
               'value'=> function($model) {
                    $orders = \common\models\OrderMaintenance::find()->where(['id' => $model->id])->andWhere(['=','status' , 10])->all();
                       return count($orders);
                   },
                'headerOptions' => ['style' => 'width:5%'],
            ],
            //'phone',
            //'email:email',
            //'registration_date',
            //'expire_date',
            //'status_account',
            //'description:ntext',
            //'lang',
            //'lat',
            //'header_report_image',
            //'footer_report_image',
            //'tax_num',
            //'user_created_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
      </div>
    </div>
</div>
