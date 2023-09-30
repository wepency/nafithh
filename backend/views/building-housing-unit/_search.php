<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BuildingHousingUnitSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="building-housing-unit-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'building_id') ?>

    <?= $form->field($model, 'housing_unit_name') ?>

    <?= $form->field($model, 'floors_no') ?>


    <?php // echo $form->field($model, 'rent_price') ?>

    <?php // echo $form->field($model, 'area') ?>

    <?php // echo $form->field($model, 'rooms') ?>

    <?php // echo $form->field($model, 'entrances') ?>

    <?php // echo $form->field($model, 'has_parking') ?>

    <?php // echo $form->field($model, 'toilets') ?>

    <?php // echo $form->field($model, 'kitchen') ?>

    <?php // echo $form->field($model, 'furniture') ?>

    <?php // echo $form->field($model, 'conditioner_num') ?>

    <?php // echo $form->field($model, 'pool') ?>

    <?php // echo $form->field($model, 'detail') ?>

    <?php // echo $form->field($model, 'using_for') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'for_rent') ?>

    <?php // echo $form->field($model, 'for_sale') ?>

    <?php // echo $form->field($model, 'sale_price') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
