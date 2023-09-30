<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SettingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="setting-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'site_name') ?>

    <?= $form->field($model, 'site_name_en') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'description_en') ?>

    <?php // echo $form->field($model, 'key_words') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'address_en') ?>

    <?php // echo $form->field($model, 'mobile') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'email_admin') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'email_complaint') ?>

    <?php // echo $form->field($model, 'facebook') ?>

    <?php // echo $form->field($model, 'twitter') ?>

    <?php // echo $form->field($model, 'youtube') ?>

    <?php // echo $form->field($model, 'comment_status') ?>

    <?php // echo $form->field($model, 'profile') ?>

    <?php // echo $form->field($model, 'profile_en') ?>

    <?php // echo $form->field($model, 'program_block_text') ?>

    <?php // echo $form->field($model, 'program_block_text_en') ?>

    <?php // echo $form->field($model, 'lng') ?>

    <?php // echo $form->field($model, 'lat') ?>

    <?php // echo $form->field($model, 'project_default_image') ?>

    <?php // echo $form->field($model, 'news_story_default_image') ?>

    <?php // echo $form->field($model, 'gallery_default_image') ?>

    <?php // echo $form->field($model, 'logo') ?>

    <?php // echo $form->field($model, 'icon') ?>

    <?php // echo $form->field($model, 'key_google_map') ?>

    <?php // echo $form->field($model, 'admin_theme') ?>

    <?php // echo $form->field($model, 'content_donate') ?>

    <?php // echo $form->field($model, 'content_donate_en') ?>

    <?php // echo $form->field($model, 'content_employee_empty') ?>

    <?php // echo $form->field($model, 'content_employee_empty_en') ?>

    <?php // echo $form->field($model, 'content_volunteer') ?>

    <?php // echo $form->field($model, 'content_volunteer_en') ?>

    <?php // echo $form->field($model, 'image_volunteer') ?>

    <?php // echo $form->field($model, 'image_about_block2') ?>

    <?php // echo $form->field($model, 'image_about_block3') ?>

    <?php // echo $form->field($model, 'view_analysis_number') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
