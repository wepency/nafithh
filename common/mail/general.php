<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php if (Yii::$app->language=="en") print "ltr"; else print "rtl";?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

   <div style="text-align:right;background-color:white;border:1px solid #456;border-radius:3px;padding:10px;font-size: 18px;font-family: 'Times New Roman';color:black">

	   <h2><?= Yii::t('app',$subject) ?></h2>
	   <br>
	   <p> <?= $message ?></p>
	   <br>
	   <br>
	   <img src="<?= yii::$app->BaseUrl->baseUrl?>/images/logo.png">

	</div>

</body>
</html>
<?php $this->endPage() ?>
