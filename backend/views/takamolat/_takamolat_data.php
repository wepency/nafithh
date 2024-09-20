<?php

/* @var $this yii\web\View */
/* @var $model common\models\Ad */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php if ($takamolat): ?>

    <div class="order-index  box box-primary">

        <div class="pageAdvPublic">
            <div class="pageAdvPublicContent">
                <div class="title-page-withLink ">ترخيص الإعلان العقاري
                    <div class="Ads-logo-image show-in-print"><span
                                style="box-sizing: border-box; display: inline-block; overflow: hidden; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px; position: relative; max-width: 100%;"><span
                                    style="box-sizing: border-box; display: block; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px; max-width: 100%;"><img
                                        alt="" aria-hidden="true"
                                        src="data:image/svg+xml,%3csvg%20xmlns=%27http://www.w3.org/2000/svg%27%20version=%271.1%27%20width=%27282%27%20height=%2780%27/%3e"
                                        style="display: block; max-width: 100%; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px;"></span><img
                                    alt="Logo"
                                    src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
                                    decoding="async" data-nimg="intrinsic"
                                    style="position: absolute; inset: 0px; box-sizing: border-box; padding: 0px; border: none; margin: auto; display: block; width: 0px; height: 0px; min-width: 100%; max-width: 100%; min-height: 100%; max-height: 100%;"><noscript></noscript></span>
                    </div>
                </div>
                <div class="MainCard_mainCard__2ZwDY">
                    <div class="blockForm">
                        <div class="titleBlock"><span>معلومات ترخيص الإعلان </span></div>
                        <div class="dataForm">
                            <div class="groupItemShow">
                                <div class="lableShow">رقم ترخيص الإعلان</div>
                                <div class="showData withText">
                                    <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                         aria-hidden="true" viewBox="0 0 24 24" data-testid="TextSnippetOutlinedIcon">
                                        <path d="M14.17 5 19 9.83V19H5V5h9.17m0-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V9.83c0-.53-.21-1.04-.59-1.41l-4.83-4.83c-.37-.38-.88-.59-1.41-.59zM7 15h10v2H7v-2zm0-4h10v2H7v-2zm0-4h7v2H7V7z"></path>
                                    </svg>
<!--                                    --><?php //= $model->adLicenseNumber ?>
                                </div>
                            </div>

                            <div class="groupItemShow">
                                <div class="lableShow">تاريخ إصدار الإعلان</div>
                                <div class="showData">
                                    <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                         aria-hidden="true" viewBox="0 0 24 24" data-testid="CalendarTodayOutlinedIcon">
                                        <path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 18H4V10h16v11zm0-13H4V5h16v3z"></path>
                                    </svg>

                                    <?= $takamolat?->result?->advertisement?->creationDate ?>
                                </div>
                            </div>

                            <div class="groupItemShow">
                                <div class="lableShow">تاريخ انتهاء رخصة الإعلان</div>

                                <div class="showData">
                                    <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                         aria-hidden="true" viewBox="0 0 24 24" data-testid="CalendarTodayOutlinedIcon">
                                        <path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 18H4V10h16v11zm0-13H4V5h16v3z"></path>
                                    </svg>
                                    <?= $takamolat?->result?->advertisement?->endDate ?>
                                </div>
                            </div>
                            <div class="groupItemShow">
                                <div class="lableShow">غرض الإعلان</div>
                                <div class="showData">
                                    <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                         aria-hidden="true" viewBox="0 0 24 24" data-testid="CalendarTodayOutlinedIcon">
                                        <path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 18H4V10h16v11zm0-13H4V5h16v3z"></path>
                                    </svg>

                                    <?= $takamolat?->result?->advertisement?->advertisementType ?>
                                </div>
                            </div>

                            <div class="groupItemShow">
                                <div class="lableShow">اسم المعلن</div>
                                <div class="showData">
                                    <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                         aria-hidden="true" viewBox="0 0 24 24" data-testid="TextSnippetOutlinedIcon">
                                        <path d="M14.17 5 19 9.83V19H5V5h9.17m0-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V9.83c0-.53-.21-1.04-.59-1.41l-4.83-4.83c-.37-.38-.88-.59-1.41-.59zM7 15h10v2H7v-2zm0-4h10v2H7v-2zm0-4h7v2H7V7z"></path>
                                    </svg>

                                    <?= $takamolat?->result?->advertisement?->advertiserName ?>

                                </div>
                            </div>

                            <div class="groupItemShow">
                                <div class="lableShow">رقم رخصة فال للوساطة والتسويق العقاري</div>
                                <div class="showData">
                                    <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                         aria-hidden="true" viewBox="0 0 24 24"
                                         data-testid="WorkspacePremiumOutlinedIcon">
                                        <path d="M9.68 13.69 12 11.93l2.31 1.76-.88-2.85L15.75 9h-2.84L12 6.19 11.09 9H8.25l2.31 1.84-.88 2.85zM20 10c0-4.42-3.58-8-8-8s-8 3.58-8 8c0 2.03.76 3.87 2 5.28V23l6-2 6 2v-7.72c1.24-1.41 2-3.25 2-5.28zm-8-6c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6 2.69-6 6-6zm0 15-4 1.02v-3.1c1.18.68 2.54 1.08 4 1.08s2.82-.4 4-1.08v3.1L12 19z"></path>
                                    </svg>

                                    <?= $takamolat?->result?->advertisement?->advertiserId ?>

                                </div>
                            </div>

                            <div class="groupItemShow">
                                <div class="lableShow">سعر الوحدة</div>
                                <div class="showData">
                                    <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                         aria-hidden="true" viewBox="0 0 24 24" data-testid="BusinessOutlinedIcon">
                                        <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"></path>
                                    </svg>

                                    <?= $takamolat?->result?->advertisement?->propertyPrice ?>

                                </div>
                            </div>

                            <div class="groupItemShow">
                                <div class="lableShow">قنوات الإعلان</div>

                                <div class="showData">
                                    <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                         aria-hidden="true" viewBox="0 0 24 24" data-testid="CampaignOutlinedIcon">
                                        <path d="M18 11v2h4v-2h-4zm-2 6.61c.96.71 2.21 1.65 3.2 2.39.4-.53.8-1.07 1.2-1.6-.99-.74-2.24-1.68-3.2-2.4-.4.54-.8 1.08-1.2 1.61zM20.4 5.6c-.4-.53-.8-1.07-1.2-1.6-.99.74-2.24 1.68-3.2 2.4.4.53.8 1.07 1.2 1.6.96-.72 2.21-1.65 3.2-2.4zM4 9c-1.1 0-2 .9-2 2v2c0 1.1.9 2 2 2h1v4h2v-4h1l5 3V6L8 9H4zm5.03 1.71L11 9.53v4.94l-1.97-1.18-.48-.29H4v-2h4.55l.48-.29zM15.5 12c0-1.33-.58-2.53-1.5-3.35v6.69c.92-.81 1.5-2.01 1.5-3.34z"></path>
                                    </svg>

                                    <?= $takamolat?->result?->advertisement?->channels[0] ?>
                                </div>
                            </div>

                            <div class="groupItemShow">
                                <div class="lableShow">رمز الإستجابة السريعة</div>

                                <div class="AdQr_adQrImageContainer__80TBW" id="adQrImageContainer">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= $takamolat?->result?->advertisement?->qrCodeUrl ?>"
                                         alt=""/>

                                    <div class="AdQr_adQrText__oPLm8">
                                    <span>
                                        <span class="AdQr_adQrTextBiggerWord__iMCMt">
                                            <?php
                                            echo match ($takamolat?->result?->isValid) {
                                                true => 'نشط',
                                                default => 'غير نشط'
                                            };
                                            ?>
                                        </span>

                                        #<?= $takamolat->result->advertisement->adLicenseNumber ?>
                                    </span>

                                        <span>ينتهي بتاريخ

                                        <span id="endDateText"
                                              style="margin-right: 4px;"><?= $takamolat->result->advertisement->endDate ?></span>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="groupItemShow">
                                <div class="lableShow">قناة ترخيص الإعلان</div>
                                <div>
                                <span style="box-sizing: border-box; display: inline-block; overflow: hidden; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px; position: relative; max-width: 100%;"><span
                                            style="box-sizing: border-box; display: block; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px; max-width: 100%;"><img
                                                alt="" aria-hidden="true"
                                                src="data:image/svg+xml,%3csvg%20xmlns=%27http://www.w3.org/2000/svg%27%20version=%271.1%27%20width=%27141%27%20height=%2740%27/%3e"
                                                style="display: block; max-width: 100%; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px;"></span><img
                                            alt="Logo"
                                            src="https://eservicesredp.rega.gov.sa/_next/image?url=%2F_next%2Fstatic%2Fmedia%2Flogo.efa0062e.png&w=384&q=75"
                                            decoding="async" data-nimg="intrinsic" class="showData"
                                            style="position: absolute; inset: 0px; box-sizing: border-box; padding: 0px; border: none; margin: auto; display: block; width: 0px; height: 0px; min-width: 100%; max-width: 100%; min-height: 100%; max-height: 100%;"
                                            srcset="https://eservicesredp.rega.gov.sa/_next/image?url=%2F_next%2Fstatic%2Fmedia%2Flogo.efa0062e.png&w=384&q=75"><noscript></noscript></span>
                                </div>
                            </div>
                            <div class="groupItemShow">
                                <div class="lableShow">حالة الإعلان</div>
                                <div class="showData">
                                    <div class="statusNhc statusSuccess">
                                        <?php
                                        echo match ($takamolat?->result?->isValid) {
                                            true => 'نشط',
                                            default => 'غير نشط'
                                        };
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="blockForm">
                        <div class="titleBlock"><span>معلومات العقار </span></div>
                        <div class="dataForm">
                            <div class="groupItemShow">
                                <div class="lableShow">نوع العقار</div>
                                <div class="showData">
                                    <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                         aria-hidden="true" viewBox="0 0 24 24" data-testid="ApartmentOutlinedIcon">
                                        <path d="M17 11V3H7v4H3v14h8v-4h2v4h8V11h-4zM7 19H5v-2h2v2zm0-4H5v-2h2v2zm0-4H5V9h2v2zm4 4H9v-2h2v2zm0-4H9V9h2v2zm0-4H9V5h2v2zm4 8h-2v-2h2v2zm0-4h-2V9h2v2zm0-4h-2V5h2v2zm4 12h-2v-2h2v2zm0-4h-2v-2h2v2z"></path>
                                    </svg>

                                    <?= $takamolat?->result?->advertisement?->propertyType ?>

                                </div>
                            </div>
                            <div class="groupItemShow">
                                <div class="lableShow">استخدام العقار</div>
                                <div class="showData">
                                    <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                         aria-hidden="true" viewBox="0 0 24 24" data-testid="ApartmentOutlinedIcon">
                                        <path d="M17 11V3H7v4H3v14h8v-4h2v4h8V11h-4zM7 19H5v-2h2v2zm0-4H5v-2h2v2zm0-4H5V9h2v2zm4 4H9v-2h2v2zm0-4H9V9h2v2zm0-4H9V5h2v2zm4 8h-2v-2h2v2zm0-4h-2V9h2v2zm0-4h-2V5h2v2zm4 12h-2v-2h2v2zm0-4h-2v-2h2v2z"></path>
                                    </svg>

                                    <?= $takamolat?->result?->advertisement?->propertyUsages[0] ?>

                                </div>
                            </div>

                            <div class="groupItemShow">
                                <div class="lableShow">مساحة العقار</div>
                                <div class="showData">
                                    <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                         aria-hidden="true" viewBox="0 0 24 24" data-testid="SwapHorizOutlinedIcon">
                                        <path d="M6.99 11 3 15l3.99 4v-3H14v-2H6.99v-3zM21 9l-3.99-4v3H10v2h7.01v3L21 9z"></path>
                                    </svg>
                                    <?= $takamolat?->result?->advertisement?->propertyArea ?>

                                </div>
                            </div>
                            <div class="groupItemShow">
                                <div class="lableShow">عرض الشارع</div>
                                <div class="showData">
                                    <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                         aria-hidden="true" viewBox="0 0 24 24" data-testid="SwapHorizOutlinedIcon">
                                        <path d="M6.99 11 3 15l3.99 4v-3H14v-2H6.99v-3zM21 9l-3.99-4v3H10v2h7.01v3L21 9z"></path>
                                    </svg>

                                    <?= $takamolat?->result?->advertisement?->streetWidth ?>
                                </div>
                            </div>
                            <div class="groupItemShow">
                                <div class="lableShow">رقم المخطط</div>
                                <div class="showData">
                                    <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                         aria-hidden="true" viewBox="0 0 24 24" data-testid="SignpostOutlinedIcon">
                                        <path d="M13 10h5l3-3-3-3h-5V2h-2v2H4v6h7v2H6l-3 3 3 3h5v4h2v-4h7v-6h-7v-2zM6 6h11.17l1 1-1 1H6V6zm12 10H6.83l-1-1 1-1H18v2z"></path>
                                    </svg>

                                    <?= $takamolat?->result?->advertisement?->planNumber ?>
                                </div>
                            </div>
                            <div class="groupItemShow">
                                <div class="lableShow">واجهة العقار</div>
                                <div class="showData">
                                    <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                         aria-hidden="true" viewBox="0 0 24 24" data-testid="ApartmentOutlinedIcon">
                                        <path d="M17 11V3H7v4H3v14h8v-4h2v4h8V11h-4zM7 19H5v-2h2v2zm0-4H5v-2h2v2zm0-4H5V9h2v2zm4 4H9v-2h2v2zm0-4H9V9h2v2zm0-4H9V5h2v2zm4 8h-2v-2h2v2zm0-4h-2V9h2v2zm0-4h-2V5h2v2zm4 12h-2v-2h2v2zm0-4h-2v-2h2v2z"></path>
                                    </svg>

                                    <?= $takamolat?->result?->advertisement?->propertyFace ?>
                                </div>
                            </div>

                            <div class="groupItemShow">
                                <div class="lableShow">خدمات العقار</div>
                                <div class="showData">
                                    <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                         aria-hidden="true" viewBox="0 0 24 24" data-testid="ApartmentOutlinedIcon">
                                        <path d="M17 11V3H7v4H3v14h8v-4h2v4h8V11h-4zM7 19H5v-2h2v2zm0-4H5v-2h2v2zm0-4H5V9h2v2zm4 4H9v-2h2v2zm0-4H9V9h2v2zm0-4H9V5h2v2zm4 8h-2v-2h2v2zm0-4h-2V9h2v2zm0-4h-2V5h2v2zm4 12h-2v-2h2v2zm0-4h-2v-2h2v2z"></path>
                                    </svg>
                                    <!--                                كهرباء, مياه, صرف صحي-->

                                    <?php
                                    $services = $takamolat?->result?->advertisement?->propertyUtilities;

                                    echo implode(', ', $services);
                                    ?>
                                </div>
                            </div>
                            <div class="groupItemShow">
                                <div class="lableShow">عمر العقار</div>
                                <div class="showData">
                                    <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                         aria-hidden="true" viewBox="0 0 24 24" data-testid="CalendarTodayOutlinedIcon">
                                        <path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 18H4V10h16v11zm0-13H4V5h16v3z"></path>
                                    </svg>

                                    <?= $takamolat?->result?->advertisement?->propertyAge ?>
                                </div>
                            </div>

                            <div class="groupItemShow">
                                <div class="lableShow">عدد الغرف</div>
                                <div class="showData">
                                    <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                         aria-hidden="true" viewBox="0 0 24 24" data-testid="ApartmentOutlinedIcon">
                                        <path d="M17 11V3H7v4H3v14h8v-4h2v4h8V11h-4zM7 19H5v-2h2v2zm0-4H5v-2h2v2zm0-4H5V9h2v2zm4 4H9v-2h2v2zm0-4H9V9h2v2zm0-4H9V5h2v2zm4 8h-2v-2h2v2zm0-4h-2V9h2v2zm0-4h-2V5h2v2zm4 12h-2v-2h2v2zm0-4h-2v-2h2v2z"></path>
                                    </svg>
                                    <?= $takamolat?->result?->advertisement?->numberOfRooms ?>
                                </div>
                            </div>
                            <div class="groupItemShow">
                                <div class="lableShow">مطابقة كود البناء السعودي</div>

                                <div class="showData">
                                    <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                         aria-hidden="true" viewBox="0 0 24 24" data-testid="ApartmentOutlinedIcon">
                                        <path d="M17 11V3H7v4H3v14h8v-4h2v4h8V11h-4zM7 19H5v-2h2v2zm0-4H5v-2h2v2zm0-4H5V9h2v2zm4 4H9v-2h2v2zm0-4H9V9h2v2zm0-4H9V5h2v2zm4 8h-2v-2h2v2zm0-4h-2V9h2v2zm0-4h-2V5h2v2zm4 12h-2v-2h2v2zm0-4h-2v-2h2v2z"></path>
                                    </svg>

                                    <?php
                                    echo match ($takamolat?->result?->advertisement?->complianceWithTheSaudiBuildingCode) {
                                        'true' => 'مطابق',
                                        default => 'غير مطابق',
                                    };
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="dataForm">
                            <div class="groupItemShow">
                                <div class="lableShow">حدود وأطوال العقار</div>
                                <div class="showData"><?= $takamolat?->result?->advertisement?->theBordersAndLengthsOfTheProperty ?></div>
                            </div>
                            <div class="groupItemShow">
                                <div class="lableShow">الضمانات ومدتها</div>
                                <div class="showData"><?= $takamolat?->result?->advertisement?->guaranteesAndTheirDuration ?></div>
                            </div>
                            <div class="groupItemShow">
                                <div class="lableShow">الالتزامات الآخرى على العقار</div>
                                <div class="showData"><?= $takamolat?->result?->advertisement?->obligationsOnTheProperty ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="blockForm">
                        <div class="titleBlock"><span>عنوان العقار </span></div>

                        <div class="dataForm">
                            <div class="groupItemShow">
                                <div class="lableShow">المنطقة</div>
                                <div class="showData">
                                    <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                         aria-hidden="true" viewBox="0 0 24 24" data-testid="LocationOnOutlinedIcon">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z"></path>
                                        <circle cx="12" cy="9" r="2.5"></circle>
                                    </svg>

                                    <?= $takamolat?->result?->advertisement?->location?->region ?>
                                </div>
                            </div>
                            <div class="groupItemShow">
                                <div class="lableShow">المدينة</div>
                                <div class="showData">
                                    <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                         aria-hidden="true" viewBox="0 0 24 24" data-testid="LocationOnOutlinedIcon">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z"></path>
                                        <circle cx="12" cy="9" r="2.5"></circle>
                                    </svg>

                                    <?= $takamolat?->result?->advertisement?->location?->city ?>
                                </div>
                            </div>
                            <div class="groupItemShow">
                                <div class="lableShow">الحي</div>
                                <div class="showData">
                                    <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                         aria-hidden="true" viewBox="0 0 24 24" data-testid="LocationOnOutlinedIcon">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z"></path>
                                        <circle cx="12" cy="9" r="2.5"></circle>
                                    </svg>

                                    <?= $takamolat?->result?->advertisement?->location?->district ?>
                                </div>
                            </div>
                            <div class="groupItemShow">
                                <div class="lableShow">الشارع</div>
                                <div class="showData">
                                    <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                         aria-hidden="true" viewBox="0 0 24 24" data-testid="LocationOnOutlinedIcon">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z"></path>
                                        <circle cx="12" cy="9" r="2.5"></circle>
                                    </svg>

                                    <?= $takamolat?->result?->advertisement?->location?->street ?>
                                </div>
                            </div>
                            <div class="groupItemShow">
                                <div class="lableShow">الرمز البريدي</div>
                                <div class="showData">
                                    <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                         aria-hidden="true" viewBox="0 0 24 24" data-testid="FmdGoodOutlinedIcon">
                                        <path d="M12 12c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm6-1.8C18 6.57 15.35 4 12 4s-6 2.57-6 6.2c0 2.34 1.95 5.44 6 9.14 4.05-3.7 6-6.8 6-9.14zM12 2c4.2 0 8 3.22 8 8.2 0 3.32-2.67 7.25-8 11.8-5.33-4.55-8-8.48-8-11.8C4 5.22 7.8 2 12 2z"></path>
                                    </svg>
                                    <?= $takamolat?->result?->advertisement?->location?->postalCode ?>
                                </div>
                            </div>
                            <div class="groupItemShow">
                                <div class="lableShow">رقم المبنى</div>
                                <div class="showData">
                                    <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                         aria-hidden="true" viewBox="0 0 24 24" data-testid="FmdGoodOutlinedIcon">
                                        <path d="M12 12c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm6-1.8C18 6.57 15.35 4 12 4s-6 2.57-6 6.2c0 2.34 1.95 5.44 6 9.14 4.05-3.7 6-6.8 6-9.14zM12 2c4.2 0 8 3.22 8 8.2 0 3.32-2.67 7.25-8 11.8-5.33-4.55-8-8.48-8-11.8C4 5.22 7.8 2 12 2z"></path>
                                    </svg>

                                    <?= $takamolat?->result?->advertisement?->location?->buildingNumber ?>
                                </div>
                            </div>
                            <div class="groupItemShow">
                                <div class="lableShow">الرمز الإضافي</div>
                                <div class="showData">
                                    <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium css-vubbuv" focusable="false"
                                         aria-hidden="true" viewBox="0 0 24 24" data-testid="FmdGoodOutlinedIcon">
                                        <path d="M12 12c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm6-1.8C18 6.57 15.35 4 12 4s-6 2.57-6 6.2c0 2.34 1.95 5.44 6 9.14 4.05-3.7 6-6.8 6-9.14zM12 2c4.2 0 8 3.22 8 8.2 0 3.32-2.67 7.25-8 11.8-5.33-4.55-8-8.48-8-11.8C4 5.22 7.8 2 12 2z"></path>
                                    </svg>

                                    <?= $takamolat?->result?->advertisement?->location?->additionalNumber ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>