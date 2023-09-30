<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

use johnitvn\ajaxcrud\CrudAsset;
/* @var $this yii\web\View */
/* @var $searchModel common\models\BuildingHousingUnitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Create Contract');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contracts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
 $this->registerJsFile('@web/js/jquery-3.3.1.min.js',['position' =>yii\web\View::POS_HEAD]);

yii::$app->assetManager->bundles['yii\web\JqueryAsset'] = false;

 $this->registerJsFile('@web/js/smartWizard.min.js',['depends' => [\yii\web\JqueryAsset::class]]);
 $this->registerCssFile('@web/css/smart_wizard_all.min.css',['depends' => [yii\bootstrap\BootstrapAsset::class]]);
?>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    'size' => Modal::SIZE_LARGE,
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>

<style type="text/css">
    .table-responsive {
        overflow-x: unset; 
    }
}
</style>
<div class="building-housing-unit-index box box-primary">
    <?php /*Pjax::begin();*/ ?>
    <div class="box-body table-responsive">
        <div id="smartwizard">
            <ul class="nav">
               <li>
                   <a class="nav-link" href="#step-1" data="1">
                      Step 1
                      <br><?= Yii::t('app', 'Owner Information') ?>
                                    
                   </a>
               </li>
               <li>
                   <a class="nav-link" href="#step-2" data="2">
                      Step 2
                      <br><?= Yii::t('app', 'Housing Unit Information') ?>

                   </a>
               </li>
               <li>
                   <a class="nav-link" href="#step-3" data="3">
                      Step 3
                      <br><?= Yii::t('app', 'Renter Information') ?>
                   </a>
               </li>
               <li>
                   <a class="nav-link" href="#step-4" data="4">
                      Step 4
                      <br><?= Yii::t('app', 'Contract Information') ?>
                      
                   </a>
               </li>
               <li>
                   <a class="nav-link" href="#step-5" data="5">
                      Step 5
                      <br><?= Yii::t('app', 'Generate Installment') ?>
                      
                   </a>
               </li>
            </ul>

            <div class="tab-content">
               <div id="step-1" class="tab-pane" role="tabpanel">
                    <?php echo Yii::$app->view->renderFile('@backend/views/contract/_check-or-add.php'); ?>
               </div>
               <div id="step-2" class="tab-pane" role="tabpanel">
                    
               </div>
               <div id="step-3" class="tab-pane" role="tabpanel">
                  <?php echo Yii::$app->view->renderFile('@backend/views/contract/_check-or-add-renter.php'); ?>
               </div>
               <div id="step-4" class="tab-pane" role="tabpanel">
                  
               </div>

               <div id="step-5" class="tab-pane" role="tabpanel">
                  
               </div>
               
            </div>
        </div>
    </div>
    <?php /*Pjax::end();*/ ?>
</div>
    
    
<script type="text/javascript">
    $(document).ready(function(){
        $(document).ajaxSuccess(function (event, xhr) {
            var forceClose = xhr && xhr.responseJSON;
            if(xhr.responseJSON && xhr.responseJSON.forceClose){
            $('#smartwizard').smartWizard("loader", "hide");
              $('#smartwizard').smartWizard("next");
            }
        });
        $(document).ajaxComplete(function (event, xhr) {
            $('#smartwizard').smartWizard("loader", "hide");
        });
         modal = new ModalRemote('#ajaxCrubModal');
        
         checkOrAdd = function(){
            $(".loadMainContent").on("click", function(event ){
                $('#smartwizard').smartWizard("loader", "show");
                var form = $( this ).parent().parent();
                var formData = form.serialize();
                $.ajax({
                url: form.attr("action"),
                type: form.attr("method"),
                data: formData,
                success: function (data) {
                    if(data.error == true)
                    {
                        modal.show();
                        if (data.forceReload !== undefined && data.forceReload) {
                            if (data.forceReload == 'true') {
                                // Backwards compatible reload of fixed crud-datatable-pjax
                                $.pjax.reload({container: '#crud-datatable-pjax'});
                            } else {
                                $.pjax.reload({container: data.forceReload});
                            }
                        }

                        // Close modal if data contains forceClose field
                        if (data.forceClose !== undefined && data.forceClose) {
                            modal.hide();
                            return;
                        }

                        if (data.size !== undefined)
                            modal.setSize(data.size);

                        if (data.title !== undefined)
                            modal.setTitle(data.title);

                        if (data.content !== undefined)
                            modal.setContent(data.content);

                        if (data.footer !== undefined)
                            modal.setFooter(data.footer);

                        if ($(modal.content).find("form")[0] !== undefined) {
                            modal.setupFormSubmit(
                                $(modal.content).find("form")[0],
                                $(modal.footer).find('[type="submit"]')[0]
                            );
                        }
                        $('#smartwizard').smartWizard("loader", "hide");

                        // ModalRemote
                        // modal.beforeRemoteRequest();
                        // modal.successRemoteResponse(data);
                        // modal.doRemote(form.attr("action"), form.attr("method"),null);
                    }else if(data.error == false){

                        $('#smartwizard').smartWizard("next");
                    }else{
                      console.log("else");
                        $('#smartwizard').smartWizard("loader", "hide");
                    }
                    
                },
                error: function () {
                    alert("Something went wrong");
                }
                });
            });
        }
  // SmartWizard initialize
  // $('#smartwizard').smartWizard();

    $('#smartwizard').smartWizard({
       theme: 'arrows',
       justified: true, 
        autoAdjustHeight: false, 
    transition: {
        animation: 'fade', // Effect on navigation, none/fade/slide-horizontal/slide-vertical/slide-swing
    },
     toolbarSettings: {
        toolbarPosition: 'none', // none, top, bottom, both
        toolbarButtonPosition: 'right', // left, right, center
        showNextButton: true, // show/hide a Next button
        showPreviousButton: true, // show/hide a Previous button
        toolbarExtraButtons: [] // Extra buttons to show on toolbar, array of jQuery input/buttons elements
    },
    });
  $("#smartwizard").on("stepContent", function(e, anchorObject, stepIndex, stepDirection) {
    // Read data value from the anchor element
    var datalink    = anchorObject.attr('data');
    var ajaxURL = '<?php echo Yii::$app->urlManager->baseUrl."/contract/step"; ?>' ;
 
    // Return a promise object
    return new Promise((resolve, reject) => {

      
    // Ajax call to fetch your content
    $.ajax({
        method  : "GET",
        url     : ajaxURL,
        data     : {'step':datalink},

        beforeSend: function( xhr ) {
          $('#smartwizard').smartWizard("loader", "show");

        }
    }).done(function( res ) {
        resolve(res);
          // Hide the loader
        $('#smartwizard').smartWizard("loader", "hide");
        //         $( "form" ).each(function(index) {

        // console.log(this); 
        //           $(this).on("beforeSubmit", function(){
        //             var form = $(this);
        //               var formData = form.serialize();
        //                       modal.doRemote(form.attr("action"), form.attr("method"),formData);
        //                        return false;

        //             });
        //       });
      }).fail(function(err) {
          // Reject the Promise with error message to show as content
          reject(" <?php echo yii::t('app',"An error loading the resource")?> ");
          // Hide the loader
          $('#smartwizard').smartWizard("loader", "hide");
      });
 
    });


});

     

//   $("#smartwizard").on("leaveStep", function(e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
// return confirm("Do you want to leave the step " + currentStepIndex + "?");
//   });
});

</script>
