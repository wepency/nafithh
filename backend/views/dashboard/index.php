<?php
use common\models\Setting;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper; 


/* @var $this yii\web\View */

 ?>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Morris charts -->
<!-- <script src="../vendor/bower-asset/adminlte/bootstrap/js/bootstrap.min.js"></script>

<script src="../vendor/bower-asset/adminlte/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="../vendor/bower-asset/adminlte/plugins/chartjs/Chart.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="../vendor/bower-asset/adminlte/plugins/morris/morris.min.js"></script>
<script src="../vendor/bower-asset/adminlte/plugins/fastclick/fastclick.js"></script> -->
    <div class="content">
     
        <div class="site-index" style="margin-bottom: : 150px;min-height: 770px;">
        	<?php 

	            echo Yii::$app->view->renderFile("@backend/views/dashboard/".$option['type'].".php",['option'=>$option]);

        	?>
        </div>
    </div>
<!-- Bootstrap 3.3.7 -->
 

<!-- AdminLTE App -->
<!-- AdminLTE for demo purposes -->
<!-- page script -->

