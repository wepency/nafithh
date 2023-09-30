<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\BaseStringHelper;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use common\models\Nationality;



/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="user-index  box box-primary">
    <div class="box-header with-border">
        <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </div>

	<div class="box-body table-responsive">
    	<?php Pjax::begin(['id' => 'sub-category-id','timeout'=>false]); ?> 
       <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
                 // 'id',
                  'name',
                  // 'username',
                  [       
                    'attribute' => 'identity_id',
                    'label' => Yii::t('app','Identity Id'),
                    
                ],
                  'mobile',
                  [       
                    'attribute' => 'identityType._name',
                    'label' => Yii::t('app','Identity Type'),
                    
                ],

                //  'password_hash',
                //  'auth_key',
                 // 'password_reset_token',
                  'email:email',
                  // 'avatar',
              [
                'format' => 'html',
                'label' => yii::t('app','Image'),
                'attribute'=>'avatar',
                'value' => function ($model) {
                  if($model->avatar){
                    return Html::img(Yii::$app->uploadUrl->baseUrl."/avatar/".$model->avatar,
                    ['width' => '50']);}
                  else{
                    return  Html::img(Yii::$app->uploadUrl->baseUrl."/avatar/user.png",['width' => '50']);
                  }
                }
              ],

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
                  'attribute' => 'user_type',
                  'filter' => array_diff_key( yii::$app->params['userType'][Yii::$app->language],array_flip(['admin_user','estate_officer_user','maintenance_officer_user']) ),
                  'value'=> function($model) {
                         return Yii::$app->params['userType'][Yii::$app->language][$model->user_type];
                     }
              ],
              [       
                  // 'attribute' => 'user_type',
                  // 'filter' => array_diff_key( yii::$app->params['userType'][Yii::$app->language],array_flip(['admin_user','estate_officer_user','maintenance_officer_user']) ),
                  'label' => Yii::t('app','User Type available'),
                  'value'=> function($model) {
                      $list = \common\components\MultiUserType::activeUserTypes($model->id);
                      if(count($list) > 0) {
                        // print_r($list); die();
                         return implode( ' , ',$list);
                     }
                    return '';
                  }
              ],
              [
                 'attribute'=>'nationality_id',
                  'filter'=> ArrayHelper::map(Nationality::find()->all(),'id','_name'),
                 'value'=> 'nationality._name'
              ],
              [
                   'attribute'=>'created_at',
                    //'label'=> Yii::t('app','Product No'),
                    'value'=> function($model) {
                       return date('d-m-Y H:i:s',$model->created_at);
                      }
              ],
              [

                    'label' => Yii::t('app', 'Login As user'),
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'text-align: center;'],
                    'value'=> function($models) {
                            return Html::a('<span class="fa fa-location-arrow" aria-hidden="true"></span>',
                                ['/site/login-as-user',
                                    'user_id' => $models->id,
                                ],
                                ['data-method' => 'post','class' => 'btn btn-default ','target'=>'_blank']
                            );
                    },
                    'visible' => yii::$app->user->can('developer'),
                ],
                  //'updated_at',
                  //'mobile',
                  //'activation_code',
                  //'confirmed',
                  //'user_type',
                 
                  //'description:ntext',
                  //'address',
                  //'city_id',
                  //'venue_id',
              [
                  'class' => 'yii\grid\ActionColumn',
                  'template' => '{update} {delete}',
              ],
                  
              ],
    ]); ?>

 </div>
 
           
    </div>

