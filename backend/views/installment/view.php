<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Installment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Installments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$estateOffice = $model->contract->estateOffice;

?>
<div class="installment-view box box-primary template">
    <div id="divIdToPrint">
       <?=Yii::$app->view->renderFile('@backend/views/print/_header.php',['estateOffice'=>$estateOffice,'label' => Yii::t('app', 'Installements')]);?>

        <?=Yii::$app->view->renderFile('@backend/views/installment/_temp.php',['model'=>$model]);?>

        <?=Yii::$app->view->renderFile('@backend/views/print/_footer.php',['estateOffice'=>$estateOffice]);?>
    </div>
     <div class="contract-content">
        <div class="clearfix"></div>
        <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();"> <?=yii::t('app','Print');?>
            <i class="fa fa-print"></i>
        </a>
        <a class="btn btn-lg green hidden-print margin-bottom-5" href="<?=Yii::$app->homeUrl?>contract"> <?=yii::t('app','Contracts');?>
            <i class="fa fa-check"></i>
        </a>
        <?= Html::a('<i class="fa fa-picture-o"></i>',null,  [
                'class'=>'btn btn-primary hidden-print', 
                'id'=>'down-jpg',
                // 'target'=>'_blank', 
                'data-toggle'=>'tooltip', 
                'title'=>'Will open the generated image file in a new window'
            ]);?>
        <?= Html::a('<i class="fa fa-download"></i>', null, [
                'class'=>'btn btn-primary hidden-print', 
                'id'=>'down-pdf',
                // 'target'=>'_blank', 
                'data-toggle'=>'tooltip', 
                'title'=>'Will open the generated PDF file in a new window'
            ]);?>
    </div>
<?php /*
    <div class="box-body table-responsive">
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'id',
            'contract.contract_no',
            [
                'attribute' =>'renter_id',
                'value'=> function($model) {
                       return $model->renter->name;
                   }
            ],
            'installment_no',
            [
               'attribute'=>'payment_status',
               'value'=> function($model) {
                       return Yii::$app->params['statusPayment2'][Yii::$app->language][$model->payment_status];
                   }
            ],
            'amount',
            'amount_text',
            'amount_paid',
            'amount_remaining',
            'details:ntext',
            'start_date',
            'end_date',
        ],
    ]) ?>
    </div>
    */?>
</div>
<?php 
$crt = Yii::$app->request->csrfToken;
$script = <<< JS
 $('#down-pdf').click(function(){
downloadPdf("$model->id","$crt");
        
    });
JS;
$this->registerJs($script);
?>
