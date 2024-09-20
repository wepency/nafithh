<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Owner */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Owners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="owner-view box box-primary">
    <div class="box-header">
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
                'name',
                'username',
                [
                   'attribute'=>'user_type',
                  'value'=> function($model) {
                        return yii::t('app',$model->user_type);
                    }
                ],
                // 'password_hash',
                // 'auth_key',
                // 'password_reset_token',
                // 'status',
                'email:email',
                'mobile',
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
                'created_at:date',
                'updated_at:date',
            ],
        ]) ?>
    </div>
</div>
