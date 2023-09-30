<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

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
            // 'created_at',
            // 'updated_at',
            'mobile',
            'name',
            [
               'attribute'=>'nationality_id',
               'value'=> function($model) {
                    return $model->nationality->_name;
                }
            ],
            // 'coocker_rank_id',
            // 'rate',
            // 'activation_code',
            // 'confirmed',
            'user_type',
            // 'avatar',
            // 'latitude',
            // 'longitude',
            // 'website',
            // 'bio',
            // 'description:ntext',
        ],
    ]) ?>

</div>
