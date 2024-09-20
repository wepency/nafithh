<style type="text/css" >
.sw{position:relative}.sw *,.sw ::after,.sw ::before{box-sizing:border-box}
 .sw.sw-loading{-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}
 .sw.sw-loading::after{content:"";display:block;position:absolute;opacity:1;top:0;left:0;height:100%;width:100%;background:rgba(255,255,255,.7);z-index:2;transition:all .2s ease}
 .sw.sw-loading::before{content:'';display:inline-block;position:absolute;top:45%;left:45%;width:2rem;height:2rem;border:10px solid #f3f3f3;border-top:10px solid #3498db;border-radius:50%;z-index:10;-webkit-animation:spin 1s linear infinite;animation:spin 1s linear infinite}
 @-webkit-keyframes spin{0%{transform:rotate(0)}100%{transform:rotate(360deg)}}
 @keyframes spin{0%{transform:rotate(0)}100%{transform:rotate(360deg)}}
</style>


<?php 

$js = <<< JS

$(document).ready(function(){
    loader = $(".loader");
    if(loader.length > 0){
        $(document).ajaxStart(function (event, xhr) {
            $(".loader").addClass("sw-loading sw");
        });
        $(document).ajaxComplete(function (event, xhr) {
            $(".loader").removeClass("sw-loading sw");
        });

    }
 });
  
JS;

$this->registerJs($js,yii\web\View::POS_END);
?>
