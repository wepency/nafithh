<?php

$setting = yii::$app->SiteSetting->info()
?>
<style>
    header.header,
    footer.footer-section {
        display: none;
    }

    footer#landing-footer {
        display: block;
        background: rgba(255, 255, 255, 0) url('/images/landing-footer.png') no-repeat center center;
        background-size: cover;
        border-style: none;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 0;
        border-radius: 0;
        width: 100%;
        height: 210px;
        position: relative;
        text-align: center;
        padding: 3rem;
        color: #ffffff !important;
    }

    .page-container {
        font-family: 'DinNextRegular', sans-serif;
        margin-top: 10px;
    }

    span.header {
        font-weight: 900;
        font-size: 25px;
        position: relative;
    }

    .main-hero {
        padding: 5rem 0;
    }

    span.header .text {
        z-index: 10;
        position: relative;
    }

    .with-bg::after {
        content: '';
        position: absolute;
        background: rgba(163, 224, 225, 1);
        width: 100%;
        height: 23px;
        right: 0;
        top: 13px;
        z-index: 0;
    }

    .big-text {
        font-size: 40px;
    }

    .big-text .with-bg {
        font-size: 40px;
    }

    section.main-features {
        padding: 5rem 0;
    }

    section.integration {
        background: #eafbff;
        padding: 5rem 0;
    }

    .big-text .with-bg::after {
        content: '';
        height: 29px;
        top: 24px;
    }

    .mid-size-text {
        font-size: 28px;
        padding: .5rem;
    }

    .whatsapp-btn {
        background-color: #25D366;
        border-color: #25D366;
    }
    .whatsapp-btn:hover {
        background-color: #1ebe57;
        border-color: #1ebe57;
    }

    @media (min-width: 768px) {
        .offset-md-3 {
            margin-right: 25% !important;
            margin-left: 0 !important;
        }
    }
</style>

<div class="page-container">


    <section class="main-hero">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <h1 class="mb-3">نافذة الرقمية</h1>

                    <h2 class="big-text"><span class="header with-bg"><span class="text">نظام سحابي</span></span> مرن
                        وذكي لإدارة الأملاك
                        يخدم كامل المنظومة العقارية بطريقة سهلة.</h2>

                    <a href="https://api.whatsapp.com/send?phone=+966<?= $setting->mobile ?>;" class="btn whatsapp-btn text-white mt-3">
                        <i class="fab fa-whatsapp"></i> تواصل معنا الأن
                    </a>
                </div>

                <div class="col-md-6 col-xs-12">
                    <img src="/images/laptop.png" alt="laptop"/>
                </div>
            </div>
        </div>
    </section>

    <section class="main-features">
        <div class="container">
            <h3 class="text-center"><span class="header with-bg"><span class="text big-text">من خدماتنا</span></span>
            </h3>

            <div class="">
                <div class="row">

                    <div class="col-md-6 col-xs-12">
                        <p class="mid-size-text">
                            <img src="/images/verification.png" alt="verification"/>
                            <span>إمكانية دخول المستأجر والمالك للنظام لمتابعة عقاراتهم</span>
                        </p>
                    </div>

                    <div class=" col-md-6 col-xs-12">
                        <p class="mid-size-text">
                            <img src="/images/verification.png" alt="verification"/>
                            <span>تسويق العقارات من خلال معرض نافذة المرخص من الهيئة العامة للعقار</span>
                        </p>
                    </div>

                </div>
            </div>

            <div class="">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <p class="mid-size-text">
                            <img src="/images/verification.png" alt="verification"/>
                            <span>نظام محاسبي يتيح التصفية للملاك ومعرفة دخل المكتب</span>
                        </p>
                    </div>

                    <div class="col-md-6 col-xs-12">
                        <p class="mid-size-text">
                            <img src="/images/verification.png" alt="verification"/>
                            <span>طلب الصيانة من مزودي خدمة موثوقين وبجودة عالية</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="integration">
        <div class="container text-center">
            <h2 style="font-weight: bolder">نظام معتمد من</h2>
            <img src="/images/license.svg" style="max-height: 200px" alt="license">
        </div>
    </section>

</div>
<footer id="landing-footer">
    <img style="max-height: 100px" src="https://nafithh.sa/web/uploads/setting/7up6ZZGib4VZdfiZYxmWdCDI-LOuNI9H.png"
         alt="logo image"/>
    <h6><b style="color: #ffffff">إطلالتك لعالم العقار</b></h6>
</footer>