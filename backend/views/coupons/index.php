<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\Plan;

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $coupon common\models\Coupon */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Coupons');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coupon-index  box box-primary">

    <?php  if(yii::$app->user->can('/order/create')){ ?>
        <div class="box-header with-border">
          <?= Html::a(Yii::t('app', 'Create Order'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    <?php } ?>

    <div class="box-body table-responsive">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'coupon',
                'discount',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    </div>
</div>
