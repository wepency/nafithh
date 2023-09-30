<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BuildingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="building-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'owner_id') ?>

    <?= $form->field($model, 'instrument_number') ?>

    <?= $form->field($model, 'building_name') ?>

    <?= $form->field($model, 'building_type_id') ?>

    <?php // echo $form->field($model, 'floors') ?>

    <?php // echo $form->field($model, 'housing_units') ?>

    <?php // echo $form->field($model, 'city_id') ?>

    <?php // echo $form->field($model, 'district_id') ?>

    <?php // echo $form->field($model, 'lang') ?>

    <?php // echo $form->field($model, 'lat') ?>

    <?php // echo $form->field($model, 'building_status') ?>

    <?php // echo $form->field($model, 'building_age') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'housing_units_available') ?>

    <?php // echo $form->field($model, 'housing_units_rented') ?>

    <?php // echo $form->field($model, 'has_parking') ?>

    <?php // echo $form->field($model, 'for_rent') ?>

    <?php // echo $form->field($model, 'for_sale') ?>

    <?php // echo $form->field($model, 'rent_price') ?>

    <?php // echo $form->field($model, 'sale_price') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
