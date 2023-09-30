<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Statement */
?>
<div class="statement-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'housing_id',
            // 'building_id',
            'debit',
            'credit',
            // 'type',
            // 'reference_id',
            // 'estate_office_id',
            // 'owner_id',
            // 'contract_id',
            // 'instalment_ids:ntext',
            'detail:ntext',
            // 'detail_en:ntext',
            'created_date',
            'year',
        ],
    ]) ?>

</div>
