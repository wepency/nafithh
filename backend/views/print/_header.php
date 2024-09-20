<?php
if (Yii::$app->language=='ar'){
    $this->registerCssFile(Yii::$app->BaseUrl->baseUrl.'/css/style-temp.css');
}else{
    $this->registerCssFile(Yii::$app->BaseUrl->baseUrl.'/css/style-temp-en.css');
}
$this->registerCss("
    /*<![CDATA[*/
      @media print {

        @page * {
            margin: 0px;
            padding: 0px;

        }
        .contract-block .form-group label{
            // width: auto;
                // padding-inline-end: 20px;
        }
        p.copyrights {
            margin-bottom: 0 !important;
            color: #ffffff !important;
            text-align: center !important;
        }
        .footer {
            background-color: #282828 !important;
            -webkit-print-color-adjust: exact;
        }
        a {
            color: #3c8dbc !important;
        }
     }
     /*]]>*/
    ",
    ['media' => 'print']
);

$logo = isset($estateOffice->header_report_image)? $estateOffice->header_report_image : '';
?>


<header class="contract-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-md-4  col-sm-4 col-xs-4">
                <img src="<?=Yii::$app->BaseUrl->baseUrl?>/images/logo-nafeza.png" class="right-logo">
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                <h2><?=$label?> </h2>
                <hr>
            </div>
            <div class="col-lg-4 col-md-4  col-sm-4 col-xs-4 text-left">
                <?php if($logo){ ?>
                    <img src="<?=$logo?>" class="left-logo img-footer" style="max-height: 150px;">
                <?php } ?>
            </div>
        </div>
    </div>
</header>

<?php /* if($logo){ ?>
    <div class="row " bis_skin_checked="1">
        <div class="col-sm-12 col-xs-12 pad" bis_skin_checked="1">
            <div  style="height: 150px; text-align: center;">
                <img src="<?=$logo?>" style="height: 100%; width: auto;" class=" img-footer center-block img-responsive">
            </div>
        </div>
    </div>
<?php } ?>*/?>