<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Setting1 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="setting1-view box box-primary">

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
            'slug',
            'slug_en',
            'site_name',
            'site_name_en',
            [
                'format' => 'html',
                'attribute' =>'description',
            ],
            [
                'format' => 'html',
                'attribute' =>'description_en',
            ],
            'address',
            'address_en',
            'mobile',
            'phone',
            'email_admin:email',
            'email:email',
            'facebook',
            'twitter',
            'youtube',
            'linkedin',
            'instagram',
            'lang',
            'lat',
            'profile',
            'profile_en',
            'tax_number',
            'services_text:ntext',
            'services_text_en:ntext',
            'partners_text:ntext',
            'partners_text_en:ntext',
            'key_words',
            'key_google_map',
            'admin_theme',
            'visit_number',
            'tax_percent_maintenance_order',
            'added_tax',
            'contract_default_no',
            'contract_default_period',
            'contract_maintenance_free_no',
            'contract_maintenance_free_period',
            'enable_installment_deposit_bank',
            'enable_installment_cash',
            'enable_installment_pay_card',
            'enable_installment_network',
            'copyright',
            'copyright_en',
            'about_image',
            'logo',
            'icon',
        ],
    ]) ?>
    </div>
</div>
