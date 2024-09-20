<?php

use yii\helpers\Html;

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-index  box box-primary">


    <div class="box-header with-border">
      <?= Html::a(Yii::t('app', 'Create Setting'), ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="box-body table-responsive"> 
      <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'site_name',
            'site_name_en',
            'description:ntext',
            'description_en:ntext',
            //'key_words',
            //'address',
            //'address_en',
            //'mobile',
            //'phone',
            //'email_admin:email',
            //'email:email',
            //'email_complaint:email',
            //'facebook',
            //'twitter',
            //'youtube',
            //'comment_status',
            //'profile',
            //'profile_en',
            //'program_block_text',
            //'program_block_text_en',
            //'lang',
            //'lat',
            //'project_default_image',
            //'news_story_default_image',
            //'gallery_default_image',
            //'logo',
            //'icon',
            //'key_google_map',
            //'admin_theme',
            //'content_donate:ntext',
            //'content_donate_en:ntext',
            //'content_employee_empty:ntext',
            //'content_employee_empty_en:ntext',
            //'content_volunteer:ntext',
            //'content_volunteer_en:ntext',
            //'image_volunteer',
            //'image_about_block2',
            //'image_about_block3',
            //'view_analysis_number',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
