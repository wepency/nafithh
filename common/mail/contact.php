<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="rtl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

   <div style="text-align:right;direction: rtl;background-color:#fbfbfb;border:1px solid #456;border-radius:3px;padding:10px;font-size: 18px;font-family: 'Times New Roman';">

	   <h2>رسالة تواصل معنا من الموقع</h2>
	   <div> اسم المرسل : <?= $contactForm->name ?></div>
	   <div> البريد الإلكتروني : <?= $contactForm->email ?></div>
	   <div> رقم الجوال : <?= $contactForm->mobile ?></div>
	   <div>  محتوى الرسالة : </div>
	   <div>  <?= nl2br($contactForm->body) ?></div>
	   <br>
	   <br>
	   
	   
	   <img src="<?= Yii::$app->uploadUrl->baseUrl."/logo.png"; ?>">

	</div>

</body>
</html>
<?php $this->endPage() ?>
