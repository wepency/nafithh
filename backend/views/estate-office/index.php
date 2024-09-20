<?php

use common\models\City;
use common\models\District;
use yii\bootstrap\Alert;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\EstateOfficeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Estate Offices');
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="estate-office-index box box-primary">
        <?php Pjax::begin(); ?>
        <div class="box-header with-border">
            <?= Html::a(Yii::t('app', 'Create Estate Office'), ['create'], ['class' => 'btn btn-success btn-flat']) ?>
        </div>

        <?php
        // Check if the "force-delete" flash message is set
        if (Yii::$app->session->hasFlash('force-delete')) {
            $forceDeleteMessage = Yii::$app->session->getFlash('force-delete');

            // Display the Bootstrap alert
            echo Alert::widget([
                'options' => [
                    'class' => 'alert alert-danger alert-dismissible fade show',
                    'role' => 'alert',
                ],
                'body' => $forceDeleteMessage,
            ]);
        }
        ?>
        <?= Yii::$app->view->renderFile('@backend/views/layouts/_filter_date.php', ['model' => $searchModel, 'label' => yii::t('app', 'Registration Date')]); ?>
        <div class="box-body table-responsive">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'layout' => "{summary}\n{items}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'id',
                        'headerOptions' => ['style' => 'width:2%'],
                    ],
                    [
                        'label' => yii::t('app', 'Number') . ' ' . yii::t('app', 'Renters'),
                        'value' => function ($model) {
                            return count($model->estateOfficeRenters);
                        },
                        'headerOptions' => ['style' => 'width:5%'],
                    ],
                    [
                        'label' => yii::t('app', 'Number') . ' ' . yii::t('app', 'Owners'),
                        'value' => function ($model) {
                            return count($model->estateOfficeOwners);
                        },
                        'headerOptions' => ['style' => 'width:5%'],
                    ],
                    [
                        'label' => yii::t('app', 'Number') . ' ' . yii::t('app', 'Buildings'),
                        'value' => function ($model) {
                            return count($model->estateOfficeBuildings);
                        },
                        'headerOptions' => ['style' => 'width:5%'],
                    ],
                    [
                        'label' => yii::t('app', 'Number') . ' ' . yii::t('app', 'Contracts'),
                        'value' => function ($model) {
                            return count($model->contracts);
                        },
                        'headerOptions' => ['style' => 'width:5%'],
                    ],
                    [
                        'attribute' => 'name',
                        'headerOptions' => ['style' => 'width:8%'],
                    ],
                    [
                        'attribute' => 'mobile',
                        'headerOptions' => ['style' => 'width:6%'],
                    ],
                    //'logo',
                    'registration_code',
                    'auth_person',
                    [
                        'attribute' => 'city_id',
                        'filter' => ArrayHelper::map(City::find()->where(['>', 'id', 0])->all(), 'id', '_name'),
                        'value' => 'city._name',
                        'headerOptions' => ['style' => 'width:6%'],

                    ],
                    [
                        'attribute' => 'district_id',
                        'filter' => ArrayHelper::map(District::find()->where(['>', 'id', 0])->all(), 'id', '_name'),
                        'value' => 'district._name',
                        'headerOptions' => ['style' => 'width:6%'],
                    ],
                    [
                        'attribute' => 'sms_balance',
                        'headerOptions' => ['style' => 'width:6%'],
                    ],
                    [
                        'attribute' => 'contract_balance',
                        'headerOptions' => ['style' => 'width:6%'],
                    ],
                    [
                        'attribute' => 'status_account',
                        'label' => yii::t('app', 'Status Account'),
                        'filter' => Yii::$app->params['statusAccount'][Yii::$app->language],
                        'value' => function ($model) {
                            return Yii::$app->params['statusAccount'][Yii::$app->language][$model->status_account];
                        },
                        'headerOptions' => ['style' => 'width:6%'],
                    ],
                    // 'phone',
                    // 'email:email',
                    'registration_date:date',
                    'expire_date:date',
                    // 'status_account',
                    // 'sender_name',
                    // 'description:ntext',
                    // 'city_id',
                    // 'district_id',
                    // 'lang',
                    // 'lat',
                    // 'header_report_image',
                    // 'footer_report_image',
                    // 'notification_method',
                    // 'tax_num',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        /* 'template' => '{view} {update} {delete} {balance} {contract}',
                        'buttons' => [
                            'balance' => function ($url,$model,$key) {
                                return Html::a(
                                    '<span class="glyphicon glyphicon-credit-card"></span>',
                                    $url);
                                return Html::a('Action', $url);
                            },
                            'contract' => function ($url,$model,$key) {
                                return Html::a(
                                    '<span class="glyphicon glyphicon-copy"></span>',
                                    $url);
                                return Html::a('Action', $url);
                            },
                        ], */
                    ],
                ],
            ]); ?>
        </div>
        <?php Pjax::end(); ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>

<?php

$script = <<< JS
$('body').on('click', '.force-delete', function(e) {
    const id = $(this).data('estate-id');
    
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/web/admin/estate-office/force-delete', // Adjust the URL to your actual controller action
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    if(response.success) {
                        Swal.fire({'title': 'تم الحذف بنجاح.', 'icon': 'success'});
                        window.location.reload();
                    }
                },
                error: function(error) {
                    alert('Error toggling status:', error);
                }
            });
        }
    });
    });
JS;

$this->registerJs($script);