<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\NotifTemp */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Notif Temps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="notif-temp-view box box-primary">

    <div class="box-header">
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </div>

    <div class="box-body table-responsive">
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'id',
            'name',
            'name_en',
            'title_email:email',
            'title_email_en:email',
            [
                'format' => 'html',
                'attribute' =>'body_email',
            ],
            [
                'format' => 'html',
                'attribute' =>'body_email_en',
            ],
            [
                'format' => 'html',
                'attribute' =>'body_sms',
            ],
            [
                'format' => 'html',
                'attribute' =>'body_sms_en',
            ],
            // 'enable_sms',
            // 'enable_email:email',
        ],
    ]) ?>
    </div>
</div>
