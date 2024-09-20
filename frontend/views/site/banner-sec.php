<?php
$title = (explode('-',$this->title));

?>
 <section class="page-paner-sec">
    <img src="<?=Yii::$app->assetsUrl->baseUrl?>/bennerlogin.png" class="panner-img">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-12 pl-0">
                <h4><?=$title[0]?></h4>
            </div>
        </div>
    </div>
</section>