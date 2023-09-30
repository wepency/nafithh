<?php 
//$setting = yii::$app->SiteSetting->info();
$title = (explode('-',$this->title));
//$title1 = (count($title)>0)
?>
  <section class="breadcrumb-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                              <a href="<?=Yii::$app->homeUrl?>"><?=yii::t('app','Homepage')?> </a>
                            </li>
                            <?php if (!empty($title[1])){ ?>
                            <li class="breadcrumb-item" aria-current="page">
                              <a href="<?=Yii::$app->homeUrl.Yii::$app->controller->id?>"><?=$title[0]?></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><?=$title[1]?></li>
                            <?php }else{ ?>
                            <li class="breadcrumb-item active" aria-current="page"><?=$title[0]?></li>
                            <?php } ?>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
