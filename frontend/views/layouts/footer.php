<?php
$siteSetting = yii::$app->SiteSetting->info();
Yii::$app->cache->flush();
?>

<footer class="footer-section">
    <div class="container">
        <div class="footer-content pt-5 pb-5">
            <div class="row">
                <div class="col-xl-4 col-lg-4 mb-50">
                    <div class="footer-widget">
                        <div class="footer-logo">
                            <a href="<?= Yii::$app->BaseUrl->baseUrl ?>"><img src="<?= $setting->logo ?>" class="img-fluid" alt="logo"></a>
                        </div>

                        <div class="footer-text">
                            <p>شركة نافذة الرقمية ،، نظام ذكي ومتطور لإدارة الأملاك بأسلوب سهل وميسر</p>
                        </div>

                        <div class="footer-social-icon">

                            <span>تابعنا على</span>

                            <?php if ($setting->linkedin) { ?>
                                <a href="<?= $setting->linkedin ?>"><i class="fab fa-linkedin linkedin-bg"></i></a>
                            <?php }

                            if ($setting->instagram) { ?>
                                <a href="<?= $setting->instagram ?>"><i class="fab fa-instagram instagram-bg"></i></a>
                            <?php }

                            if ($setting->twitter) { ?>
                                <a href="<?= $setting->twitter ?>"><i class="fab fa-twitter twitter-bg"></i></a>
                            <?php }

                            if ($setting->facebook) { ?>
                                <a href="<?= $setting->facebook ?>"><i class="fab fa-facebook-f facebook-bg"></i></a>
                            <?php } ?>

                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                    <div class="footer-widget">
                        <div class="footer-widget-heading">
                            <h3>روابط سريعة</h3>
                        </div>

                        <ul>
                            <li><a href="<?= Yii::$app->homeUrl ?>"><?= yii::t('app', 'Home') ?></a></li>
                            <li><a href="<?= Yii::$app->homeUrl ?>about"><?= yii::t('app', 'know Us') ?></a></li>
                            <li><a href="<?= Yii::$app->homeUrl ?>service"><?= yii::t('app', 'Our Services') ?></a></li>
                            <li><a href=<?= Yii::$app->homeUrl ?>gallery"><?= yii::t('app', 'Nafithh gallery') ?></a></li>
                            <li><a href="<?= Yii::$app->homeUrl ?>plan"><?= yii::t('app', 'Plans') ?></a></li>
                            <li><a href="<?= Yii::$app->homeUrl ?>partner"><?= yii::t('app', 'Our partners') ?></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 mb-50">
                    <div class="footer-widget">

                        <a href="https://eservicesredp.rega.gov.sa/auth/queries" target="_blank" style="display: flex;justify-content: center;margin-top: 25px;">
                            <img src="<?= Yii::$app->homeUrl ?>images/license.svg" alt="raga license" />
                        </a>

<!--                         <img src="--><?php //= $setting->logo_footer ?><!--">-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-area">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 text-center text-lg-left">
                    <div class="copyright-text">
                        <p>جميع الحقوق محفوظة &copy; <a href="<?= Yii::$app->homeUrl ?>">لشركة نافذة </a> 2024</p>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 d-none d-lg-block text-right">
                    <div class="footer-menu">
                        <ul>
                            <li><a data-target='#myModal' onclick="event.preventDefault();document.getElementById('id01').style.display='block'" href="#"><?= yii::t('app', 'Terms and Conditions'); ?></a></li>
                            <li><a data-target='#myModal' onclick="event.preventDefault();document.getElementById('id02').style.display='block'" href="#"><?= yii::t('app', 'Privacy Policy'); ?></a></li>
                            <li><a data-target='#myModal' onclick="event.preventDefault();document.getElementById('id03').style.display='block'" href="#"><?= yii::t('app', 'Ownership rights header'); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Start Footer -->
<!--<footer class="footer">-->
<!--    <div class="container">-->
<!--        <div class="row">-->
<!--            <div class="col-lg-4 col-md-4 col-sm-12 col-12 align-self-center">-->
<!--                <p class="copyrights">-->
<!--                    --><?php //= $setting->_copyright ?>
<!--                </p>-->
<!--            </div>-->
<!--            <div class="col-lg-4 col-md-4 col-sm-12 col-12 align-self-center">-->
<!--                <nav class="nav footer-social-icons justify-content-center">-->
<!--                    --><?php //if ($setting->linkedin) { ?>
<!--                        <a class="nav-link pint-ico" target="_blank" href="--><?php //= $setting->linkedin ?><!--"><i-->
<!--                                    class="fab fa-linkedin"></i></a>-->
<!--                    --><?php //}
//                    if ($setting->instagram) { ?>
<!--                        <a class="nav-link inst-ico" target="_blank" href="--><?php //= $setting->instagram ?><!--"><i-->
<!--                                    class="fab fa-instagram"></i></a>-->
<!--                    --><?php //}
//                    if ($setting->twitter) { ?>
<!--                        <a class="nav-link twet-ico" target="_blank" href="--><?php //= $setting->twitter ?><!--"><i-->
<!--                                    class="fab fa-twitter"></i></a>-->
<!--                    --><?php //}
//                    if ($setting->facebook) { ?>
<!--                        <a class="nav-link fb-ic" target="_blank" href="--><?php //= $setting->facebook ?><!--"><i-->
<!--                                    class="fab fa-facebook-f"></i></a>-->
<!--                    --><?php //} ?>
<!--                </nav>-->
<!--            </div>-->
<!--            <div class="col-lg-4 col-md-4 col-sm-12 col-12 text-left align-self-center">-->
<!--                <span onclick="event.preventDefault();document.getElementById('id01').style.display='block'"-->
<!--                   style='color:#fff;text-decoration:underline;cursor: pointer' data-toggle='modal'-->
<!--                   data-target='#myModal'>--><?php //= yii::t('app', 'Terms and Conditions'); ?><!--</span> &nbsp;&nbsp;<span-->
<!--                        style="color:#fff;">|</span>&nbsp;&nbsp;-->
<!---->
<!--                <span type="button" onclick="document.getElementById('id02').style.display='block'"-->
<!--                   style='color:#fff; text-decoration:underline;cursor: pointer' data-toggle='modal'-->
<!--                        data-target='#myModal'>--><?php //= yii::t('app', 'Privacy Policy'); ?><!--</span> &nbsp;&nbsp;<span-->
<!--                        style="color:#fff;">|</span>&nbsp;&nbsp;-->
<!---->
<!--                <span onclick="event.preventDefault();document.getElementById('id03').style.display='block'"-->
<!--                      style='color:#fff;text-decoration:underline;cursor: pointer' data-toggle='modal'-->
<!--                      data-target='#myModal'>--><?php //= yii::t('app', 'Ownership rights header'); ?><!--</span>-->
<!---->
<!--                <div class="footer-logo">-->
<!--                    <img src="https://www.nafithh.sa/images/License.png" width="100px" alt=""/>-->
<!---->
<!---->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</footer>-->


<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<!-- The Modal -->
<div id="id01" class="w3-modal" style="z-index:999999;">
    <div class="w3-modal-content" style="padding:0">
        <div class="w3-container" style="padding:0">
      <span style="background:#C6A53E;" onclick="document.getElementById('id01').style.display='none'"
            class="w3-button w3-display-topright">&times;</span>

            <div class="" style="height:430px; overflow-y:auto; margin:40px 10px 10px; padding:10px; ">
                <h2 style="margin:0px 0 20px; text-align:center;"><?= yii::t('app', 'Terms and Conditions'); ?></h2>
                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><strong><span
                                                    style="">تعاريف</span></strong><strong><span
                                                    style=""></span></strong></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style="">نافذة: شركة نافذة الرقمية لإدارة الأملاك.</span><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style="">المنصة: موقع إلكتروني على شبكة الإنترنت تقدم نافذة من خلاله خدمات إلكترونية.</span><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style="">المستخدم: أي شخص يستفيد من الخدمات الإلكترونية التي تقدمها نافذة من خلال المنصة سواء كان أصيل أو ممثل مسجلاً أو غير مسجل</span><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><strong><span
                                                    style="">مقدمة</span></strong><strong><span
                                                    style=""></span></strong></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style="">تقدم منصة نافذة خدماتها الإلكترونية عبر المنصة الإلكترونية وهي متاحة للاستخدام من قبل الجميع.</span><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style="">يخضع دخول المستخدم واستخدامه لهذه المنصة للشروط والأحكام المذكورة في هذه الوثيقة.</span><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style="">إن الخدمات والمعلومات المتوفرة على المنصة وشروط وأحكام الاستخدام تخضع لقوانين وأنظمة المملكة العربية السعودية ومنها على سبيل المثال لا الحصر: نظام الاتصالات، نظام التعاملات الإلكترونية، نظام مكافحة الجرائم المعلوماتية، ولوائح وإجراءات المركز ذات العلاقة بأسماء النطاقات وتفسر بموجبها.</span><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style="">يعد دخول المستخدم للمنصة واستخدامها موافقة على هذه الشروط والأحكام دون قيد أو شرط.</span><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><strong><span
                                                    style="">التسجيل في المنصة</span></strong><strong><span
                                                    style=""></span></strong></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style="">يقتضي استخدام الخدمات الإلكترونية التسجيل في المنصة، علماً بأنه ليست هناك رسوم لعملية التسجيل في المنصة حالياً، وفي القريب ستوفر المنصة عدة باقات تتناسب مع عملائها.</span><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><strong><span
                                                    style="">التزامات المستخدم</span></strong><strong><span
                                                    style=""></span></strong></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style="">يقر المستخدم بأن أي معلومات يقدمها عبر المنصة هي معلومات كاملة ودقيقة ومحدثة. كما يتحمل المسؤولية عن محتوى أي معلومة أو وثيقة يتم تقديمها من خلال المنصة.</span><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style="">يتحمل المستخدم المسئولية الكاملة في حالة انتحاله اسم مستخدم آخر ويحق لشركة نافذة الرقمية إيقاف الاشتراك في حال اكتشاف الانتحال مع اتخاذ الاجراءات النظامية حيال ذلك.</span><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style="">يقر المستخدم بأنه لن يقوم بتمثيل أي شخص طبيعي أو معنوي من دون أن يكون مخولاً بذلك.</span><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style="">يقر المستخدم بأن دخول المنصة واستخدامه لها سيكون لأغراض مشروعة فقط، ويلتزم بعدم استخدام المنصة أو ما يتوفر عليها من معلومات أو خدمات أو أدوات للقيام بأي عمل ينتج عنه مخالفة أو جريمة بموجب أي نظام ساري المفعول في المملكة العربية السعودية، وذلك بغض النظر عمن وجهت إليه تلك المخالفة أو ذلك الجرم.</span><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><strong><span
                                                    style="">المحتوى</span></strong><strong><span
                                                    style=""></span></strong></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style="">إن اسم نافذة (شركة نافذة الرقمية لإدارة الأملاك) وشعارها وعناوينها وكل ما تتضمنه المنصة على سبيل المثال لا الحصر من مواد ونصوص وصور ورسومات وتصاميم ونماذج وملفات وسائط متعددة وبرمجيات وتبويبها هو ملك لنافذة وتحتفظ نافذة بكافة حقوق الملكية الفكرية المتعلقة بها بما في ذلك حقوق النشر والتوزيع، ولا يسمح بإعادة طبع هذه المواد، أو توزيعها، أو تعديلها، أو استخدامها لأغراض تجارية، أو دعائية، أو إعادة نشرها بأي شكل دون الحصول على إذن خطي وصريح من نافذة.</span><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style="">تحتفظ نافذة بالحق في مراقبة أي محتوى يتم إدخاله من قبل المستخدم.</span><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style="">تحتفظ نافذة بالحق (من دون التزام) في شطب أو إزالة أو تحرير أي مواد مدخلة من شأنها انتهاك هذه الشروط والأحكام.</span><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style="">تحتفظ نافذة بالحق في حذف أي معلومات تعتبرها انتهاكاً لأي من شروط وأحكام الاستخدام دون إشعار.</span><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style="">إن المحتويات والأدوات على المنصة مقدمة للمستخدمين كما هي، من دون ضمانات من أي نوع، سواء كانت صريحة أو ضمنية.</span><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style="">قد تقود بعض الروابط على البوابة إلى مواقع إلكترونية لا يتم تشغيلها من قبل المنصة، وليس للمنصة سيطرة عليها، كما أن المنصة لا تقوم بمراجعة أو التحكم بالمحتوى الخاص بتلك المواقع، وعند اختيار المستخدم لرابط خاص بموقع خارجي، فإنه يخضع للشروط والأحكام الخاصة بذلك الموقع الخارجي.</span><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><strong><span
                                                    style="">تنازل عن الضمان</span></strong><strong><span
                                                    style=""></span></strong></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style="">تسعى نافذة إلى توفير إمكانية دخول آمن إلى المنصة وإلى الخدمات المقدمة من خلالها، لكن ونتيجة لعوامل خارجة عن سيطرة نافذة، فإن نافذة لا تضمن إمكانية الدخول المستمر بحرية ودون انقطاع وبشكل آمن إلى البوابة أو أي من خدماتها، كما لا تتحمل نافذة المسؤولية عن أي انقطاع أو تأخير أو خلل في الخدمات المقدمة عبر المنصة.</span><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style="">يقر المستخدم أن استخدامه للمنصة أو أي مادة متاحة من خلالها خاضع لمسؤولياته الخاصة، ولا توفر المنصة ولا أي من موظفيها ضمانة بأن المنصة لن تتعرض للتوقف أو أنها ستكون خالية من المشاكل أو الحذف أو الأخطاء، كما لا توجد ضمانة بشأن النتيجة التي سيحصل عليها المستخدم جراء استخدامه للمنصة أو التسجيل فيها.</span><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style="">لقد قامت نافذة باتخاذ كافة التدابير المناسبة لوضع المعلومات على المنصة وستحاول العمل على تحديث هذه المعلومات أولاً بأول، ومع هذا، فإن المنصة لا تمنح أي ضمانات صريحة أو ضمنية بخصوص دقة المعلومات المنشورة أو موافقتها لواقع الحال أو اكتمالها.</span><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><strong><span
                                                    style=""></span></strong></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><strong><span
                                                    style="">حدود المسؤولية</span></strong><strong><span
                                                    style=""></span></strong></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style="">لا تتحمل نافذة المسؤولية عن أي خسارة في الأرباح أو أي خسارة من أي نوع نتيجة للمعلومات أو الخدمات التي تقوم بتقديمها.</span><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style="">لا تتحمل نافذة المسؤولية عن أي خسارة أو تعديل أو ضرر في بيانات المستخدمين المخزنة على المنصة، مما ينشأ عنه حصول شخص غير مفوض على حق الدخول إلى بيانات المستخدم المخزنة لدى المنصة.</span><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style="">مهما كان الحال أو الظرف، فإن نافذة غير مسئولة تجاه أي من الأمور التالية على سبيل المثال لا الحصر: الإهمال الذي يتسبب في أية أضرار أو تلف من أي نوع سواء كانت مباشرة أو عارضة أو خاصة أو لاحقـة، أو أي مصاريف أو خسائر قد تنجم بسبب استخدام المستخدم للمنصة أو عدم القدرة على استخدامه إياها، أو وقوع بعض الأخطاء أو السهو أو تأخر استجابة النظام لأي سبب كان، أو إعاقة في التشغيل أو وقوع أعطال أو تعرض أجهزة الكمبيوتر للفيروسات أو تعطل النظام بالكامل، أو خسارة أي أرباح أو تعرض سمعة المستخدم للإساءة حتى لو جرى الإشعار صراحة باحتمالية وقوع مثل هذه الأمور، أو وقوع مشاكل جراء الوصول للمنصة أو الدخول إليها أو استخدامها أو الوصول من خلالها إلى مواقع أخرى.</span><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><strong><span
                                                    style="">التعديل</span></strong><strong><span
                                                    style=""></span></strong></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style="">يحق لنافذة تعديل هذه الشروط والأحكام أو استبدالها كليا بشروط وأحكام أخرى جديدة وإشعاركم بذلك، وتصبح التعديلات نافذة فور نشرها على المنصة ما لم يتم بيان خلاف ذلك، ويعتبر استمرارية دخول المستخدم للمنصة أو استخدامه للخدمات التي توفرها المنصة بمثابة موافقة منه على هذه التغييرات</span><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><strong><span
                                                    style=""></span></strong></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><strong><span
                                                    style="">حل النزاع</span></strong><strong><span
                                                    style=""></span></strong></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style=""></span></span></span></span></span></span></p>

                <p dir="RTL" style=" text-align:right"><span style="font-size:11pt"><span><span
                                    style="direction:rtl"><span style="unicode-bidi:embed"><span
                                            style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span
                                                style="">في حال نشوء أي نزاع يقع بسبب هذه البنود، أو الشروط، أو الأحكام، أو الاستخدام يتم حله وديّا وفي حال تعذّر الحل الودي ستكون المحاكم المختصة في مدينة الرياض هي جهة الاختصاص</span></span></span></span></span></span>
                </p>

                <p>&nbsp;</p>


            </div>

        </div>
    </div>
</div>

<!-- The Modal -->
<div id="id02" class="w3-modal" style="z-index:999999;">
    <div class="w3-modal-content">
        <div class="w3-container" style="padding:0;">
      <span style="background:#C6A53E;" onclick="document.getElementById('id02').style.display='none'"
            class="w3-button w3-display-topright">&times;</span>

            <div class="modal-body" style="height:430px; overflow-y:auto; margin:40px 10px 10px;padding:10px;">
                <h2 style="margin:0px 0 20px; text-align:center;"><?= yii::t('app', 'Privacy Policy'); ?></h2>
                <p dir="RTL" style="text-align:right"><span><span><span style="direction:rtl"><span
                                        style="unicode-bidi:embed"><span><span>لن يتم جمع أية معلومات خاصة بك دون سبب لذلك محدد مسبقاً. وسوف نقوم بجمع واستخدام المعلومات الشخصية فقط مع هدف تحقيق هذه الأسباب المحددة، أو لأية أغراض أخرى متوافقة، ولن يتم جمع أية معلومات أخرى دون أن نحصل على موافقة من الفرد أو المنظمات المعنية كما يقتضي القانون. سوف نحتفظ فقط المعلومات الشخصية طالما كان ذلك ضروريا لتحقيق هذه الأغراض. وسوف نقوم بجمع هذه المعلومات الشخصية عبر وسائل مشروعة فقط، وعند الحاجة فقط مع علم أو موافقة الشخص المعني.</span><span></span></span></span></span></span></span>
                </p>

                <p dir="RTL" style="text-align:right"><span><span><span style="direction:rtl"><span
                                        style="unicode-bidi:embed"><span><span></span></span></span></span></span></span>
                </p>

                <p dir="RTL" style="text-align:right"><span><span><span style="direction:rtl"><span
                                        style="unicode-bidi:embed"><span><span>ما هي المعلومات التي نقوم بجمعها؟</span><span></span></span></span></span></span></span>
                </p>

                <p dir="RTL" style="text-align:right"><span><span><span style="direction:rtl"><span
                                        style="unicode-bidi:embed"><span><span></span></span></span></span></span></span>
                </p>

                <p dir="RTL" style="text-align:right"><span><span><span style="direction:rtl"><span
                                        style="unicode-bidi:embed"><span><span>معلومات شخصية تتضمن بريدك الإلكتروني واسمك ورقم هاتفك نوع الجهاز عنوان بروتوكول شبكة الإنترنت (</span>IP<span>).</span><span></span></span></span></span></span></span>
                </p>

                <p dir="RTL" style="text-align:right"><span><span><span style="direction:rtl"><span
                                        style="unicode-bidi:embed"><span><span>الأوراق المساندة بما فيها الصك والأوراق الثبوتية لتصنيف الاعلان </span><span></span></span></span></span></span></span>
                </p>

                <p dir="RTL" style="text-align:right"><span><span><span style="direction:rtl"><span
                                        style="unicode-bidi:embed"><span><span>معلومات الإعلانات، ومنها الموقع والصور تفاصيل الإعلان.</span><span></span></span></span></span></span></span>
                </p>

                <p dir="RTL" style="text-align:right"><span><span><span style="direction:rtl"><span
                                        style="unicode-bidi:embed"><span><span>معلومات أخرى، ومنها معلومات عن تصفحك للموقع أو التطبيق.</span><span></span></span></span></span></span></span>
                </p>

                <p dir="RTL" style="text-align:right"><span><span><span style="direction:rtl"><span
                                        style="unicode-bidi:embed"><span><span>بيانات الدفع.</span><span></span></span></span></span></span></span>
                </p>

                <p dir="RTL" style="text-align:right"><span><span><span style="direction:rtl"><span
                                        style="unicode-bidi:embed"><span><span></span></span></span></span></span></span>
                </p>

                <p dir="RTL" style="text-align:right"><span><span><span style="direction:rtl"><span
                                        style="unicode-bidi:embed"><span><span>بماذا سيتم استخدام هذه المعلومات؟</span><span></span></span></span></span></span></span>
                </p>

                <p dir="RTL" style="text-align:right"><span><span><span style="direction:rtl"><span
                                        style="unicode-bidi:embed"><span><span></span></span></span></span></span></span>
                </p>

                <p dir="RTL" style="text-align:right"><span><span><span style="direction:rtl"><span
                                        style="unicode-bidi:embed"><span><span>لمنحك تجربة خاصة وتقديم أفضل الخدمات (والعمل على تلبية احتياجاتك الفردية على أفضل وجه عبر تزويدنا بمعلوماتك الشخصية)</span><span></span></span></span></span></span></span>
                </p>

                <p dir="RTL" style="text-align:right"><span><span><span style="direction:rtl"><span
                                        style="unicode-bidi:embed"><span><span>لتطوير أداء استخدام الموقع: (نسعى دوماً لتحسين خدمات الموقع استناداً على المعلومات التي نستلمها منك)</span><span></span></span></span></span></span></span>
                </p>

                <p dir="RTL" style="text-align:right"><span><span><span style="direction:rtl"><span
                                        style="unicode-bidi:embed"><span><span>لتحسين خدمة العملاء (هذه المعلومات تساعدنا على الإجابة بشكل أفضل على طلباتك الموجهة لفريق خدمة العملاء ودعم احتياجاتهم.</span><span></span></span></span></span></span></span>
                </p>

                <p dir="RTL" style="text-align:right"><span><span><span style="direction:rtl"><span
                                        style="unicode-bidi:embed"><span><span>لإرسال رسائل إلى البريد الإلكتروني أو رسائل قصيرة، إشعارات للمستخدمين عبر الموقع أو غيرها من الوسائل المتاحة لتقديم كافة</span> <span>الخدمات، والإجابة على جميع الاستفسارات والطلبات، وغيرها من الأسئلة.</span><span></span></span></span></span></span></span>
                </p>

                <p dir="RTL" style="text-align:right"><span><span><span style="direction:rtl"><span
                                        style="unicode-bidi:embed"><span><span>التسجيل التلقائي لدخول البيانات.</span><span></span></span></span></span></span></span>
                </p>

                <p dir="RTL" style="text-align:right"><span><span><span style="direction:rtl"><span
                                        style="unicode-bidi:embed"><span><span>لعمل إحصائيات وأبحاث وتقارير عقارية ومعاملات الدفع في الخدمات المتوفرة على الموقع.</span><span></span></span></span></span></span></span>
                </p>

                <p dir="RTL" style="text-align:right"><span><span><span style="direction:rtl"><span
                                        style="unicode-bidi:embed"><span><span>المشاركة مع شركاء تابعين لجهات خارجية موثوقة على سبيل المثال (الجهات الحكومية، البنوك)</span><span></span></span></span></span></span></span>
                </p>

                <p dir="RTL" style="text-align:right"><span><span><span style="direction:rtl"><span
                                        style="unicode-bidi:embed"><span><span>الشركاء الذين يستخدمون خدمات التحليل التي نوفرها.</span><span></span></span></span></span></span></span>
                </p>

                <p dir="RTL" style="text-align:right"><span><span><span style="direction:rtl"><span
                                        style="unicode-bidi:embed"><span><span>نشارك المعلومات مع جهات تنفيذ القانون أو استجابةً للطلبات القانونية التي نتلقاها</span><span>.</span></span></span></span></span></span>
                </p>

                <p dir="RTL" style="text-align:right"><span><span><span style="direction:rtl"><span
                                        style="unicode-bidi:embed"><span><span>كلمة المرور الخاصة بك في منصة نافذة أنت المسؤول الوحيد عنها لذا نرجو منك الحفاظ عليها.</span></span></span></span></span></span>
                </p>

                <p dir="RTL" style="text-align:right"><span><span><span style="direction:rtl"><span
                                        style="unicode-bidi:embed"><span><span>سنقوم بتحديث سياسة الخصوصية هذه وفقا لتقديرنا المطلق من وقت لآخر، ننصحك بمراجعة هذه الصفحة لمعرفة أية تغييرات تطرأ عليها وأن تصبح على علم بأية تعديلات مع العلم أنه في حال التحديث سيتم الإعلان عن ذلك في الموقع.</span></span></span></span></span></span>
                </p>


            </div>

        </div>
    </div>
</div>

<!-- The Modal -->
<div id="id03" class="w3-modal" style="z-index:999999;">
    <div class="w3-modal-content">
        <div class="w3-container" style="padding:0;">
      <span style="background:#C6A53E;" onclick="document.getElementById('id03').style.display='none'"
            class="w3-button w3-display-topright">&times;</span>

            <div class="modal-body" style="height:430px; overflow-y:auto; margin:40px 10px 10px;padding:10px;">
                <h2 style="margin:0px 0 20px; text-align:center;"><?= yii::t('app', 'Ownership rights header'); ?></h2>

                <p dir="RTL" style="text-align:right">
                    إن حقوق نشر وطبع المواد والمعلومات وجميع المحتويات المدرجة في الموقع هي ملك خاص لشركة موقع نافذة بما في ذلك الرسومات والشعارات والأيقونات والصور والمقاطع والتنزيلات الرقمية.
                    لا يجوز للمستخدم نسخ أو استخراج أو نشر أو تحميل أو نقل أو توزيع أو عرض أي محتوى في هذا الموقع الإلكتروني بأية طريقة كانت باستثناء ما نسمح به للمستخدم ومع الالتزام بالقيود أو الحدود المصرح بها صراحة،
                    كما يوافق على عدم تغيير أو حذف أية شعارات خاصة بالملكية يتم تنزيلها من الموقع الإلكتروني. قد يخضع المستخدم للمساءلة القانونية بموجب القوانين النافذة في حال مخالفته لأي من ذلك.
                </p>

            </div>

        </div>
    </div>
</div>


<!-- End Footer -->
<?php /*
<footer class="footer">
        <div class="top-footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-12 text-center">
                        <img src="<?=$siteSetting->logo_footer?>" class="footer-logo">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 col-12">
                        <div class="footer-title">
                            <div class="title-pin"></div>
                            <h4><?=Yii::t('app','Top Links');?></h4>
                        </div>
                        <ul class="footer-menu">
                            <li class="active">
                                <a href="<?=Yii::$app->homeURL?>">
                                    <img src="<?=Yii::$app->assetsUrl->baseUrl?>/linefuter.png" class="pin">
                                    <img src="<?=Yii::$app->assetsUrl->baseUrl?>/linefuterhover.png" class="footer-hover-pin">
                                    <span><?=yii::t('app','Homepage')?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=Yii::$app->homeURL?>about">
                                    <img src="<?=Yii::$app->assetsUrl->baseUrl?>/linefuter.png" class="pin">
                                    <img src="<?=Yii::$app->assetsUrl->baseUrl?>/linefuterhover.png" class="footer-hover-pin">
                                    <span><?=yii::t('app','About Us')?></span>
                                </a>
                            </li>
                            <!-- <li>
                                <a href="#">
                                    <img src="<?=Yii::$app->assetsUrl->baseUrl?>/linefuter.png" class="pin">
                                    <img src="<?=Yii::$app->assetsUrl->baseUrl?>/linefuterhover.png" class="footer-hover-pin">
                                    <span>عن المؤسسة</span>
                                </a>
                            </li> -->
                            <li>
                                <a href="<?=Yii::$app->homeURL?>purview">
                                    <img src="<?=Yii::$app->assetsUrl->baseUrl?>/linefuter.png" class="pin">
                                    <img src="<?=Yii::$app->assetsUrl->baseUrl?>/linefuterhover.png" class="footer-hover-pin">
                                    <span><?=Yii::t('app','Programs and Projects');?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=Yii::$app->homeUrl?>job">
                                    <img src="<?=Yii::$app->assetsUrl->baseUrl?>/linefuter.png" class="pin">
                                    <img src="<?=Yii::$app->assetsUrl->baseUrl?>/linefuterhover.png" class="footer-hover-pin">
                                    <span><?=Yii::t('app','Employment');?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=Yii::$app->homeUrl?>partner">
                                    <img src="<?=Yii::$app->assetsUrl->baseUrl?>/linefuter.png" class="pin">
                                    <img src="<?=Yii::$app->assetsUrl->baseUrl?>/linefuterhover.png" class="footer-hover-pin">
                                    <span><?=Yii::t('app','Partners');?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=Yii::$app->homeURL?>story">
                                    <img src="<?=Yii::$app->assetsUrl->baseUrl?>/linefuter.png" class="pin">
                                    <img src="<?=Yii::$app->assetsUrl->baseUrl?>/linefuterhover.png" class="footer-hover-pin">
                                    <span><?=Yii::t('app','Success Stories');?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=Yii::$app->homeURL?>complaint">
                                    <img src="<?=Yii::$app->assetsUrl->baseUrl?>/linefuter.png" class="pin">
                                    <img src="<?=Yii::$app->assetsUrl->baseUrl?>/linefuterhover.png" class="footer-hover-pin">
                                    <span><?=Yii::t('app','Complaints');?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=Yii::$app->homeURL?>volunteer">
                                    <img src="<?=Yii::$app->assetsUrl->baseUrl?>/linefuter.png" class="pin">
                                    <img src="<?=Yii::$app->assetsUrl->baseUrl?>/linefuterhover.png" class="footer-hover-pin">
                                    <span><?=Yii::t('app','Volunteers');?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=Yii::$app->homeURL?>news">
                                    <img src="<?=Yii::$app->assetsUrl->baseUrl?>/linefuter.png" class="pin">
                                    <img src="<?=Yii::$app->assetsUrl->baseUrl?>/linefuterhover.png" class="footer-hover-pin">
                                    <span><?=Yii::t('app','News and Events');?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=Yii::$app->homeURL?>gallery">
                                    <img src="<?=Yii::$app->assetsUrl->baseUrl?>/linefuter.png" class="pin">
                                    <img src="<?=Yii::$app->assetsUrl->baseUrl?>/linefuterhover.png" class="footer-hover-pin">
                                    <span><?=Yii::t('app','Photo Archive');?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=Yii::$app->homeUrl?>contact-us">
                                    <img src="<?=Yii::$app->assetsUrl->baseUrl?>/linefuter.png" class="pin">
                                    <img src="<?=Yii::$app->assetsUrl->baseUrl?>/linefuterhover.png" class="footer-hover-pin">
                                    <span><?=Yii::t('app','Contact Us');?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=Yii::$app->homeUrl?>report">
                                    <img src="<?=Yii::$app->assetsUrl->baseUrl?>/linefuter.png" class="pin">
                                    <img src="<?=Yii::$app->assetsUrl->baseUrl?>/linefuterhover.png" class="footer-hover-pin">
                                    <span><?=Yii::t('app','Reports');?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="footer-title">
                            <div class="title-pin"></div>
                            <h4><?=Yii::t('app','Contact Us');?></h4>
                        </div>
                        <ul class="list-unstyled contact-info">
                            <li class="media">
                                <i class="fas fa-map-marker-alt"></i>
                                <div class="media-body align-self-center">
                                    <span><?=$siteSetting->_address?></span>
                                </div>
                            </li>
                            <li class="media">
                                <i class="fas fa-envelope-open"></i>
                                <div class="media-body align-self-center">
                                    <span><?=$siteSetting->email?></span>
                                </div>
                            </li>
                            <li class="media">
                                <i class="fas fa-phone-volume"></i>
                                <div class="media-body align-self-center">
                                    <span><?=$siteSetting->mobile?> </span>
                                    <span><?=$siteSetting->phone?> </span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row pt-4">
                    <div class="col-md-12 col-12">
                        <div class="social-icon d-flex justify-content-center">
                            <nav class="nav">
                                <?php if($siteSetting->facebook!=""){?>
                                    <a class="nav-link" href="<?=$siteSetting->facebook?>">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                <?php }?> 

                                <?php if($siteSetting->twitter!=""){?>
                                    <a class="nav-link" href="<?=$siteSetting->twitter?>">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                 <?php }?>  

                                <?php if($siteSetting->youtube!=""){?>
                                    <a class="nav-link" href="<?=$siteSetting->youtube?>">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                <?php }?>

                                <a class="nav-link" href="<?=Yii::$app->homeUrl?>social">
                                    <i class="fas fa-globe"></i>
                                </a>

                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom-footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-sm-8 col-8 align-self-center">
                        <p class="copyright">
                            &copy; <?=Yii::t('app','All Rights Reserved');?> <a href="#"><?=Yii::t('app','  ');?><?=$siteSetting->_site_name?> </a> 2019
                        </p>
                    </div>
                    <div class="col-md-2  col-sm-4 col-4">
                        <a  href="https://italent.me/" target="_blank">
                        <p class="copyright text-center">
                            <?=Yii::t('app','Development');?> 
                        </p>
                            <img src="<?=Yii::$app->assetsUrl->baseUrl?>/Asset 6.png" >
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
	
	 */ ?>




