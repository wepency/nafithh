<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\SmsProvider;

/* @var $this yii\web\View */
/* @var $model common\models\SmsProvider */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="alert alert-warning" role="alert">
    <strong>

        <?php

    $settingSms = SmsProvider::findOne(1);

    $host_msg = $settingSms->domain;
    $user_msg = $settingSms->username;
    $password_msg =$settingSms->password;
	$xml = "&return=XML";

        if ($host_msg != NULL && $user_msg != NULL && $password_msg != NULL) {
            // New URL for the request
            $url = "https://app.mobile.net.sa/api/v1/get-balance";

            // Prepare the Bearer token (replace with your actual token)
            $bearerToken = "vPtRrBkjs25SFzUazyK02fKyNNgkLmjFw2JQqSVe";

            // Set the headers, including the Authorization Bearer token
            $options = [
                "http" => [
                    "header" => [
                        "Authorization: Bearer " . $bearerToken,
                        "Content-Type: application/json" // Adjust if needed
                    ],
                    "method" => "POST" // Assuming a GET request
                ]
            ];

            // Create a stream context
            $context = stream_context_create($options);

            // Make the request
            $response = file_get_contents($url, false, $context);

            if ($response === FALSE) {
                $FainalResult = "Error Connecting to Gateway.";
                die($FainalResult);
            } else {
                $MyCredits = $response;
            }

            $lib = json_decode($response);

            // Assuming the response is in XML format, adjust as needed
//            $lib = simplexml_load_string(iconv("windows-1256", "UTF-8", $MyCredits));

            $ResultCredit = $lib->data;

            if ($lib->status == "Success") {
                echo Yii::t('app', 'Available Balance is :') . ' ' . $ResultCredit->balance;
            } else {
                echo $ResultCredit->Message;
            }
        }

        ?>
    </strong>
</div>
<div class="sms-provider-form box box-primary">
	
    <?php $form = ActiveForm::begin(['options'=>['class'=>"form-horizontal"]]); ?>

     <div class="box-body table-responsive">
	    <fieldset>
			<div class='col-sm-12'>

				<div class=" margin-r-5 row">
					<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Domain Name') ?> </label>
					<div class='col-sm-3'><?= $form->field($model, 'domain')->textInput(['maxlength' => true])->label(false) ?></div>
					
					<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Username') ?> </label>
					<div class='col-sm-3'> <?= $form->field($model, 'username')->textInput(['maxlength' => true])->label(false) ?></div>
				</div>
				<div class=" margin-r-5 row">
					<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Password') ?> </label>
					<div class='col-sm-3'> <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label(false) ?>
						
					</div>

					<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Sender') ?> </label>
					<div class='col-sm-3'> <?= $form->field($model, 'sender')->textInput(['maxlength' => true])->label(false) ?>
						
					</div>
				</div>

				<div class="col-sm-12">
					<div class="form-group">
						<a href="https://signup.sendgrid.com/" target="_blank"><?=Yii::t('app','for doing Account in Sendgrid click here')?> </a>
					</div>
				</div>
				<div class=" margin-r-5 row">
					<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Sendgrid Username') ?> </label>
					<div class='col-sm-3'> <?= $form->field($model, 'sendgrid_username')->textInput(['maxlength' => true])->label(false) ?>
						
					</div>
					
					<label for='' class='col-sm-2 control-label'><?= Yii::t('app', 'Sendgrid Password') ?> </label>
					<div class='col-sm-3'> <?= $form->field($model, 'sendgrid_password')->passwordInput(['maxlength' => true])->label(false) ?>
						
					</div>
				</div>
          
<?php /*
        <div class="col-sm-12">
			<div class="form-group">
				<a href="https://developer.paypal.com/developer/applications/" target="_blank"> لمعرفة كيفية انشاء api الخاص بالابي بال اضغط هنا </a>
			</div>
		</div>
        <label for='' class='col-sm-2 control-label'><?=Yii::t('app','Paypal Type')?></label>
        <div class='col-sm-10'>
        <?= $form->field($model, 'paypal_type')->textInput()->label(false) ?>
        </div>

        <label for='' class='col-sm-2 control-label'><?=Yii::t('app','Sandbox')?></label>
        <div class='col-sm-10'>
        <?= $form->field($model, 'sandbox')->textInput(['maxlength' => true])->label(false) ?>
        </div>

        <label for='' class='col-sm-2 control-label'><?=Yii::t('app','Production')?></label>
        <div class='col-sm-10'>
        <?= $form->field($model, 'production')->textInput(['maxlength' => true])->label(false) ?>
        </div>

        
*/ ?>
				<label for='' class='col-sm-2 control-label'><?=Yii::t('app','Sending Status')?></label>
				<div class='col-sm-10'>
				<?php $model->isNewRecord ? $model->sending_status=1:$model->sending_status;?>
					<?= $form->field($model, 'sending_status')->radioList(Yii::$app->params['sendingStatus'][Yii::$app->language])->label(false) ?>
				</div>
	
	        </div>
	    </fieldset>
	</div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
