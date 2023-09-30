 <?php if(count($ads) > 0 ){ 
    
    $this->registerJsFile(Yii::$app->BaseUrl->baseUrl.'/js/owl.carousel.min.js',['depends' => [\yii\web\JqueryAsset::class,yii\bootstrap\BootstrapPluginAsset::class]]);
    $this->registerCssFile(Yii::$app->BaseUrl->baseUrl.'/css/owl.carousel.min.css',['depends' => [yii\bootstrap\BootstrapAsset::class]]);
    $this->registerCssFile(Yii::$app->BaseUrl->baseUrl.'/css/owl.theme.default.css',['depends' => [yii\bootstrap\BootstrapAsset::class]]);

    if (Yii::$app->language=='ar'){
        $this->registerCssFile(Yii::$app->BaseUrl->baseUrl.'/css/slider.css');
    }else{
        $this->registerCssFile(Yii::$app->BaseUrl->baseUrl.'/css/slider_en.css');
    }

?>
     <div class="row">
         <div class="col-lg-12 offset-lg-12 col-md-12 col-sm-12 col-12 login-div" style="margin-bottom: 12px;">
             <!-- new -->
            <div class="slider-add mb-4" id="sliderAdd">
                <div class="slider-add-carousel owl-carousel owl-theme">
                    <?php foreach($ads as $row){ ?>
                        <div class="slider-add-item">
                            <a <?= $row->link ? 'href="'.$row->link.'"':"" ?> target="_blank">
                                <img src="<?= $row->image ?>">
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>


    <?php

    $lang = 
    $script = <<< JS
       var lang = $('html').attr('lang');
        if(lang == 'en'){
            // new
            $('.slider-add-carousel').owlCarousel({
                rtl:false,
                loop:true,
                center:true,
                nav:true,
                dots:false,
                autoplay:true,
                slideTransition:'linear',
                margin:0,
                autoplayHoverPause: true,
                navText : ['<i class="fas fa fa-chevron-right"></i>','<i class="fas fa fa-chevron-left"></i>'],
                // dotsContainer: '.container',
                responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:1
                    },
                    1000:{
                        items:1
                    }
                }
            });
        }else{
            // new
            $('.slider-add-carousel').owlCarousel({
                rtl:true,
                loop:true,
                center:true,
                nav:true,
                dots:false,
                autoplay:true,
                slideTransition:'linear',
                margin:0,
                autoplayHoverPause: true,
                // dotsContainer: '.container',
                navText : ['<i class="fas fa fa-chevron-right"></i>','<i class="fas fa fa-chevron-left"></i>'],
                responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:1
                    },
                    1000:{
                        items:1
                    }
                }
            });
        }
    JS;
    $this->registerJs($script);
    ?>


 <?php } ?>