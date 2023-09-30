  <?php

  /* @var $this yii\web\View */
  /* @var $form yii\bootstrap\ActiveForm */
  /* @var $model \frontend\models\SignupForm */

  use yii\helpers\Html;
  use yii\bootstrap\ActiveForm;
  use yii\helpers\ArrayHelper;
  use yii\helpers\Url;
  use common\models\SignupForm;
  use kartik\file\FileInput;

use kartik\depdrop\DepDrop;



  $this->title = yii::t('app','Add New Admin');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User'), 'url' => ['index']];

  $this->params['breadcrumbs'][] = $this->title;
  ?>

<div class="user-update">


    <?= $this->render('_form', [
        'model' => $model,
        'arrImages2' => $arrImages2,
        'permission' => $permission,
        
    ]) ?>

</div>
  <!------------>

  
