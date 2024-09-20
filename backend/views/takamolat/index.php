<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Ads');
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
?>

<style>
    .toggle-status{
        display: block;
        color: #ffffff !important;
    }
</style>

<div class="ad-index box box-primary">
    <?php Pjax::begin(); ?>
    <div class="box-header with-border">
        <?= Html::a(Yii::t('app', 'Create Ad'), ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </div>

    <?php Pjax::begin(); ?>
    <div class="box-body table-responsive">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
//                    [
//                        'format' => 'html',
//                        'label' => yii::t('app','Image'),
//                        'attribute'=>'image',
//                        'value' => function ($model) {
//                            return Html::img($model->image,['width' => '150px']);
//                        },
//                    ],
                'id',
                [
                    'label' => 'صورة الاعلان',
                    'attribute' => 'imagePath',
                    'format' => 'html',
                    'value' => function ($model) {
                        $image = $model->attachments[0]->file ?? null;

                        if (!is_null($image))
                        // Assuming imagePath is a property in your model
                        return Html::img(Yii::$app->uploadUrl->baseUrl . "/attachment/" . $image, ['width' => '100', 'height' => 100]);
                    },
                ],
                [
                    'label' => 'نص الاعلان',
                    'attribute' => 'name'
                ],
                [
                    'format' => 'html',
                    'label' => 'رقم ترخيص الاعلان',
                    'attribute' => 'adLicenseNumber'
                ],
                [
                    'format' => 'html',
                    'label' => 'السعر',
                    'attribute' => 'propertyPrice'
                ],
                [
                    'attribute' => 'status',
                    'label' => 'الحالة',
                    'format' => 'html',
                    'value' => function ($model) {
                        $statusText = $model->status == 1 ? 'منشور' : 'غير منشور';
                        $buttonText = $model->status == 1 ? "<i class='fa fa-eye-slash'></i> اخفاء" : "<i class='fa fa-eye'></i> نشر";
                        $buttonClass = $model->status == 1 ? 'btn btn-danger' : 'btn btn-success';

                        return Html::tag('span', $statusText, ['class' => 'status-label']) . ' ' .
                            Html::beginTag('a', [
                                'href' => $model->id,
                                'class' => $buttonClass . ' btn-flat btn-xs toggle-status'
                            ]) . $buttonText . Html::endTag('a');
                    },
                ],
//                    [
//                        'attribute'=>'status',
//                        'filter'=> Yii::$app->params['statusCase'][Yii::$app->language],
//                        'label'=>yii::t('app','Status'),
//                        'value'=> function($model) {
//
//                            $status  = Yii::$app->params['statusCase'][Yii::$app->language][$model->status];
//                            $status .= Html::a('<span class="glyphicon glyphicon-ok"></span>', '#', [
//                                'title' => Yii::t('app', 'Activate'),
//                                'class' => 'btn btn-success btn-flat btn-xs',
//                                'data' => [
//                                    'confirm' => Yii::t('app', 'Are you sure you want to activate this item?'),
//                                    'method' => 'post',
//                                ],
//                            ]);
//
//                            return $status;
//                        }
//                    ],
//                    [
//                        'attribute'=>'page_name',
//                        'filter'=> Yii::$app->params['pageName'][Yii::$app->language],
//                        'value'=> function($model) {
//                            return Yii::$app->params['pageName'][Yii::$app->language][$model->page_name];
//                        }
//                    ],
                //'image',
                // 'status',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>

<?php
$script = <<< JS

function toggleStatus(id) {
    $.ajax({
        url: '/web/admin/takamolat/toggle-status', // Adjust the URL to your actual controller action
        type: 'POST',
        data: { id: id },
        success: function(response) {
            if(response.success) {
                window.location.reload();
            }
        },
        error: function(error) {
            alert('Error toggling status:', error);
        }
    });
}

$('body').on('click', '.toggle-status', function(e) {
    e.preventDefault();
    
    Swal.fire({
            title: 'هل انت متأكد من نشر أو اخفاء الاعلان؟',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'قبول',
            cancelButtonText: 'الغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                toggleStatus($(this).attr('href'));
            }
        });
});

JS;

$this->registerJs($script);
?>
