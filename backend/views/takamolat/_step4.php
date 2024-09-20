<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-body table-responsive">
    <div class="form-group">
        <label for="name" class="form-label required">نص الاعلان</label>

        <!-- Ad Ad Name-->
        <?= $form->field($model, 'name')->textInput(['class' => 'form-control', 'id' => 'name', 'required' => true])->label(false) ?>
    </div>

    <div class="form-group">
        <label for="description" class="form-label required">تفاصيل العقار</label>

        <!-- Ad Description -->
        <?= $form->field($model, 'description')->textarea(['rows' => 5, 'class' => 'form-control', 'id' => 'description', 'required' => true])->label(false) ?>
    </div>

    <div class="form-group">

        <label for="propertyPrice" class="form-label required">السعر</label>

        <!-- Property Price -->
        <?= $form->field($model, 'propertyPrice')->textInput(['class' => 'form-control', 'id' => 'propertyPrice', 'required' => true])->label(false) ?>

    </div>

    <!-- IS there any elevator -->
    <div class="form-group">
        <label for="elevator">هل هناك أي مصاعد؟</label>

        <div>
            <label class="switch">
                <input type="checkbox" id="elevator" name="elevator" <?= $model->elevator ? 'checked' : ''?>/>
                <span class="slider round"></span>
            </label>
        </div>
    </div>

    <!-- IS there any elevator -->
    <div class="form-group">
        <label for="furniture">هل العقار مؤثث؟</label>

        <div>
            <label class="switch">
                <input type="checkbox" id="furniture" name="furniture" <?= $model->furniture ? 'checked' : ''?>/>
                <span class="slider round"></span>
            </label>
        </div>
    </div>

    <!-- IS there any elevator -->
    <div class="form-group">
        <label for="ac">هل هناك تكييف؟</label>

        <div>
            <label class="switch">
                <input type="checkbox" id="ac" name="ac" <?= $model->ac ? 'checked' : ''?>/>
                <span class="slider round"></span>
            </label>
        </div>
    </div>

    <!-- IS there any elevator -->
    <div class="form-group">
        <label for="status">السماح بنشر الاعلان</label>

        <div>
            <label class="switch">
                <input type="checkbox" id="status" name="status" <?= $model->status ? 'checked' : ''?> />
                <span class="slider round"></span>
            </label>
        </div>
    </div>
</div>

<div class="box-footer">
    <div class="form-group">
<!--        --><?php //= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>

        <?= Html::submitButton(($model === null ? Yii::t('app', 'Add Ad') : Yii::t('app', 'Edit Ad')) . '<i class="glyphicon glyphicon-check"></i> ', ['class' => 'button button-primary', 'id' => 'submit_form']) ?>
    </div>
</div>