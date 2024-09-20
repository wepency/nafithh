<?php

use yii\widgets\Pjax;

$adSubType = Yii::$app->request->get('ad_subtype', 1);
$styleView = Yii::$app->request->get('style_view', 'gride');

?>
<?php if (count((array)$gallery) == 0) { ?>
    <section class="sec-resnews container tm-container-content" style="    position: relative;min-height: 200px;">
        <!-- <hr class="hr-work-comp"> -->
        <div style="margin-top: 150px;">
            <p class="text-uppercase text-center mb-9 font-weight-bolder"><?= Yii::t('app', 'Sorry, there are no results matching your search!'); ?></p>
        </div>
    </section>
<?php } ?>
<?php Pjax::begin([]); ?>

    <div class="row" id="grid-view" style="<?= ($styleView == 'list') ? 'display: none;' : '' ?>">

        <?php foreach ($gallery as $row): ?>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12" style="margin-bottom:30px;">
                <div class="gallary-block" style=" height: 100%;">
                    <div class="gallary-img">
                        <!--                        <a href="web/gallery/--><?php //= $row->id ?><!--">-->
                        <a href="<?= yii::$app->BaseUrl->baseUrl ?>/gallery/<?= $row->id ?>">

                            <?php

                            $created_at = null;

                            if (!is_null($row->created_at)) {
                                $created_at = new DateTime($row->created_at);
                                $created_at = $created_at->format('d F');
                            }

                            if (!empty($row->attachments)) {
                                foreach ($row->attachments as $image) { ?>
                                    <img src="<?= Yii::$app->uploadUrl->baseUrl . "/attachment/" . $image->file ?>"
                                         title="" alt=""/>

                                    <?php break;
                                }
                            } else {
                                ?>
                                <img src="<?= Yii::$app->homeUrl ?>images/default.png"
                                     data-zoom-image="<?= Yii::$app->homeUrl ?>images/default.png"/>
                            <?php } ?>

                            <!--                            <img src="https://nafithh.com/uploads/attachment/cU-uWU9ioeLczsMWBAi0F_Q73nrtBxVT1.jpeg">-->

                            <span class="badge badge-primary <?= $row->advertisementType == 'إيجار' ? 'green-bage' : 'red-bage' ?>"><?= $row->advertisementType ?></span>

                            <span class="add-time">
                                    <img src="<?= Yii::$app->homeUrl ?>images/clock-five.svg">
                                <!--                                    <span>-->
                                <?php //= $row->created_at ?><!--</span>-->
                                <?php if (!is_null($created_at)): ?>
                                    <span><?= $created_at ?></span>
                                <?php endif; ?>
                            </span>
                        </a>
                    </div>
                    <div class="gallary-disc">
                        <!--                        <a href="/web/gallery/--><?php //= $row->id ?><!--">-->
                        <a href="<?= yii::$app->BaseUrl->baseUrl ?>/gallery/<?= $row->id ?>">
                            <h5><?= $row->name ?> </h5>
                        </a>

                        <p>
                            <a href="https://maps.google.com/maps?q=," target="_blank">
                                <img src="<?= Yii::$app->homeUrl ?>images/icon-location.png">
                            </a>

                            <span><?= $row->region . ' - ' . $row->district . ' - ' . $row->city ?></span>
                        </p>

                        <p class="small">
                            <?= $row?->user?->estateOffice?->name ?? '' ?>
                        </p>

                        <div class="building-data">

                            <?php if (!is_null($row->propertyType)) : ?>
                                <span>
                                    <img src="<?= Yii::$app->homeUrl ?>images/plans.png"
                                         title="<?= yii::t('app', 'Space'); ?>" alt=""/><?= $row->propertyArea ?>
                                </span>
                            <?php endif; ?>

                            <?php if (!is_null($row->numberOfRooms)) : ?>
                                <span>
                                    <img src="<?= Yii::$app->homeUrl ?>images/hotel.png"
                                         title="<?= yii::t('app', 'Number of Rooms'); ?>"
                                         alt=""/> <?= $row->numberOfRooms ?>
                                </span>
                            <?php endif; ?>

                            <?php if (!is_null($row->propertyAge)) : ?>
                                <span>
                                    <img src="<?= Yii::$app->homeUrl ?>images/buildings.png"
                                         title="<?= yii::t('app', 'Building Age'); ?>" alt=""/> <?= $row->propertyAge ?>
                                </span>
                            <?php endif; ?>

                        </div>
                    </div>
                    <div class="p-3">
                        <a style="display: block" href="<?= yii::$app->BaseUrl->baseUrl ?>/gallery/<?= $row->id ?>" class="gallary-footer">
                            <span><?= number_format($row?->propertyPrice) ?> SAR</span>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php Pjax::end([]); ?>


<?php
$count = $pages->totalCount;
$script = <<< JS
    dataForm = $(".search-no").html($count);
JS;
$this->registerJs($script);
?>