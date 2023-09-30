<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\StatementReceiptCatch $model */

$this->title = Yii::t('app', 'Create Statement Receipt Catch');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Statement Receipt Catches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statement-receipt-catch-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
