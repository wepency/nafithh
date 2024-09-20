<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MaintenanceOffice */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Maintenance Offices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="maintenance-office-view box box-primary">

    <div class="box-header">
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <div class="box-body table-responsive">
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'id',
            'name',
            [
                'format' => 'html',
                'label' => yii::t('app','Logo'),
                'attribute'=>'logo',
                'value' => function ($model) {
                    return Html::img($model->logo,
                        ['width' => '150px']);
                },
            ],
            'registration_code',
            'auth_person',
            'mobile',
            'phone',
            'email:email',
            'registration_date',
            [
               'attribute'=>'status_account',
               'label'=>yii::t('app','Status Account'),
               'value'=> function($model) {
                       return Yii::$app->params['statusAccount'][Yii::$app->language][$model->status_account];
                   }
            ],
             [
                'format' => 'html',
                'attribute' =>'description',
            ],
            // 'description:ntext',
            'city._name',
            'district._name',
            'lang',
            'lat',
            [
                'format' => 'html',
                'label' => yii::t('app','Header Report Image'),
                'attribute'=>'header_report_image',
                'value' => function ($model) {
                    return Html::img($model->header_report_image,
                        ['width' => '200px']);
                },
            ],
            [
                'format' => 'html',
                'label' => yii::t('app','Footer Report Image'),
                'attribute'=>'footer_report_image',
                'value' => function ($model) {
                    return Html::img($model->footer_report_image,
                        ['width' => '200px']);
                },
            ],
            'tax_num',
            // 'user.user_created_id',
            'tax',
        ],
    ]) ?>
    </div>
</div>
