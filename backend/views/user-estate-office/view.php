<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Owner */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="owner-view box box-primary">
    <div class="box-header">
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'username',
                // 'password_hash',
                // 'auth_key',
                // 'password_reset_token',
                'email:email',
                // 'status',
                'created_at',
                'updated_at',
                'mobile',
                'name',
                // 'user_type',
                // 'avatar',
                // 'latitude',
                // 'longitude',
                // 'website',
                // 'bio',
                'description:ntext',
                'identity_id',
                'identityType._name',
                [
                   'attribute'=>'nationality_id',
                   'value'=> function($model) {
                        return $model->nationality->_name;
                    }
                ],
                [       
                    'attribute' => 'status',
                    'value'=> function($model) {
                           return Yii::$app->params['statusAccount'][Yii::$app->language][$model->status];
                       }
                ],
            ],
        ]) ?>
    </div>
</div>
