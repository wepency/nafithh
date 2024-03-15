<?php

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Show Ad');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ad Index'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@web/css/takamolat.css', ['position' => yii\web\View::POS_HEAD]);

?>

    <input type="hidden" id="adLicenseNumber" value="<?= $model->adLicenseNumber ?>" />
    <input type="hidden" id="adLicenseId" value="<?= $model->advertiserId ?>" />

<div id="ad-content" class="order-index  box box-primary">

</div>

<?php
$script = <<< JS

    
$(document).ready(function(){
// checkOrAdd();

        const adLicenseNumber = $('#adLicenseNumber').val();
        const adLicenseId = $('#adLicenseId').val();
        
        $.ajax({
            // url: '/admin/takamolat/post-request',
            url: '/web/admin/takamolat/post-request',
            type: 'POST',
            data: {
                'adLicenseNumber': adLicenseNumber,
                'adLicenseId': adLicenseId,
                'isUpdate': true
            },
            success: function (data) {
                $('#ad-content').html(data.viewContent);
            }
        });
});


JS;
$this->registerJs($script);
?>