<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;
//  this view for owner

/* @var $this yii\web\View */
/* @var $searchModel common\models\StatementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Income and Expenses').' :'.$office->name;
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="statement-index ">
    <div id="ajaxCrudDatatable " class="box box-primary">
        <div class="box-body table-responsive">
            <div class='col-sm-12'>
                <?=Yii::$app->view->renderFile('@backend/views/statement/_filter.php',['model'=>$searchModel,'label'=>yii::t('app','Housing Unit'),'housingList'=>$housingList]);?>
            </div>
        </div>
         <div class="box-header with-border">
        </div>
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'showPageSummary' => true,
            'columns' => require(__DIR__.'/_columns_office.php'),
            'toolbar'=> [
                ['content'=> ''],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'primary', 
                // 'heading' => '<i class="glyphicon glyphicon-list"></i> Statements listing',
                // 'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                // 'after'=>BulkButtonWidget::widget([
                //             'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Delete All',
                //                 ["bulk-delete"] ,
                //                 [
                //                     "class"=>"btn btn-danger btn-xs",
                //                     'role'=>'modal-remote-bulk',
                //                     'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                //                     'data-request-method'=>'post',
                //                     'data-confirm-title'=>'Are you sure?',
                //                     'data-confirm-message'=>'Are you sure want to delete this item'
                //                 ]),
                //         ]).                        
                //         '<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
