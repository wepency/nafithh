<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\InstallmentReceiptCatch */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Installment Receipt Catches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$estateOffice = $model->installment->contract->estateOffice;

?>
<div class="installment-receipt-catch-view box box-primary template">
    <div id="divIdToPrint">
    <?=Yii::$app->view->renderFile('@backend/views/print/_header.php',['estateOffice'=>$estateOffice,'label'=>Yii::t('app', 'Receipt Catches')]);?>

    <?=Yii::$app->view->renderFile('@backend/views/installment-receipt-catch/_temp.php',['model'=>$model]);?>

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
    <div class="box-body table-responsive " data-html2canvas-ignore>
        <fieldset>
            <legend><?=Yii::t('app','Attachments')?> :</legend>
            <div class='col-sm-12'> 
                <div class="clearfix"></div>
                <div class='col-sm-12'>
                    <?php   
                        $attWidget =  new \common\components\MultiAttachmentWidget(['model'=>$model]);
                        echo $attWidget->runForView();
                    ?>
                </div>
                <div class="clearfix"></div>
            </div>
        </fieldset>
    </div>
<?php /*
    <div class="box-body table-responsive">
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'id',
            'installment_id',
            'userReceive.name',
            // 'receipt_catch_no',
            [
               'attribute'=>'payment_method',
               'value'=> function($model) {
                       return Yii::$app->params['PayMethod'][Yii::$app->language][$model->payment_method];
                   }
            ],
            [
               'attribute' => 'payment_status',
               'value'=> function($model) {
                       return Yii::$app->params['statusPayment2'][Yii::$app->language][$model->payment_status];
                   },
            ],
            'amount_paid',
            'amount_remaining',
            'details:ntext',
            'created_date',
        ],
    ]) ?>
    </div>*/?>
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
