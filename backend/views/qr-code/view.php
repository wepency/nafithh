<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Owner */

$this->title = 'Qr Code';
?>

<style>

    /*h1 {*/
    /*    font-family: 'DinNextBold', sans-serif;*/
    /*    !* Other styles for heading 1 *!*/
    /*}*/

    /*p {*/
    /*    !* Other styles for paragraphs *!*/
    /*}*/
</style>

<div class="text-center">
    <?= $html ?>

    <div  class="button">
<!--        <a class="btn btn-success" href='/admin/export/download' target="_blank"><i class="fa fa-download"></i> --><?php //= \Yii::t('app', 'Download Here') ?><!--</a>-->

        <?=
        Html::a('<i class="fa fa-download"></i>'.\Yii::t('app', 'Download Here').'</a>',['/export/download'], [
                'target'=>'_blank',
            'class' => 'btn btn-success'
        ]);
        ?>
    </div>
</div>