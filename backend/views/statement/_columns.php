<?php
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
//  this view for office

Yii::$app->cache->flush();

return [
    // [
    //     'class' => 'kartik\grid\CheckboxColumn',
    //     'width' => '20px',
    // ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'housing_id',
        'filter'=>false,
        'value'=> 'housingUnit.housing_unit_name'
        
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'building_id',
        'filter'=> ArrayHelper::map(\common\models\Building::find()->CurrentUser()->andWhere(['building.id'=>$buildingIds])->all(),'id','building_name'),
        'value'=> 'building.building_name'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'debit',
        'pageSummary' =>true,
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'credit',
        'pageSummary' =>true,
        // 'pageSummary' =>function ($summary, $data, $widget) { print_r($summary); die(); },
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'type',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'reference_id',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'estate_office_id',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'owner_id',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'contract_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'instalment_ids',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'detail',
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'detail_en',
    // ],
    [
        'class' => 'kartik\grid\FormulaColumn',
        'value' => function ($model, $key, $index, $widget) { 
           return null;
        },
        'width' => '0px',
        'format' => ['decimal', 2],
        'pageSummary' => function ($model, $index, $widget) { 
            $index = -10000;
            $p = compact('model', 'widget', 'index');
            // if(is_int($widget->col(3, $p))){
            // var_dump($widget->col(3, $p)); die();
            // }
            if(is_numeric($widget->col(3, $p)) && is_numeric($widget->col(4, $p))){
              $total = (float) $widget->col(3, $p) - (float) $widget->col(4, $p);
              return yii::t('app','Total').'  : '. (string) $total;
            }
            return yii::t('app','Total').'  : ';
        },
        'pageSummaryOptions' => ['colspan' => 2],

        // 'footer' => true
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'created_date',
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'year',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'template' => (yii::$app->user->can('developer'))? '{view} {delete}' :'{view} ' ,
        // 'template' => '{view} {delete}' ,
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],

];   