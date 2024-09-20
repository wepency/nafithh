<?php

use johnitvn\ajaxcrud\CrudAsset;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BuildingHousingUnitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Add new advertisement');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
// Register the CSS file
$this->registerCssFile('@web/css/takamolat.css', ['position' => yii\web\View::POS_HEAD]);
$this->registerCssFile('@web/css/style.css', ['position' => yii\web\View::POS_HEAD]);
$this->registerCssFile('https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css', ['position' => yii\web\View::POS_HEAD]);

$this->registerJsFile('@web/js/jquery-3.3.1.min.js', ['position' => yii\web\View::POS_HEAD]);
//$this->registerJsFile('@web/js/jquery-validate.min.js', ['position' => yii\web\View::POS_HEAD]);
//$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js', ['position' => yii\web\View::POS_HEAD]);

yii::$app->assetManager->bundles['yii\web\JqueryAsset'] = false;

$this->registerJsFile('@web/js/smartWizard.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('@web/css/smart_wizard_all.min.css', ['depends' => [yii\bootstrap\BootstrapAsset::class]]);

Modal::begin([
    "id" => "ajaxCrudModal",
    'size' => Modal::SIZE_LARGE,
    "footer" => "",// always need it for jquery plugin
])
?>

<?php Modal::end(); ?>

<div class="building-housing-unit-index box box-primary">

    <div class="box-body table-responsive">
        <?php

        $link = isset($model->id) ? 'update/' . $model?->id : 'create';
        $form = ActiveForm::begin(['method' => 'post', 'action' => ["/takamolat/{$link}"], 'options' => ['class' => "form_check_owner", 'id' => 'form_takamolat']]);

        ?>

        <div id="smartwizard">
            <ul class="nav">
                <li>
                    <a class="nav-link" href="#step-1">
                        <?= Yii::t('app', 'Step 1') ?>
                        <br><?= Yii::t('app', 'adLicense') ?>
                    </a>
                </li>

                <li>
                    <a class="nav-link" href="#step-2">
                        <?= Yii::t('app', 'Step 2') ?>
                        <br><?= Yii::t('app', 'Location') ?>
                    </a>
                </li>

                <li>
                    <a class="nav-link" href="#step-3">
                        <?= Yii::t('app', 'Step 3') ?>
                        <br><?= Yii::t('app', 'Ad Images') ?>
                    </a>
                </li>

                <li>
                    <a class="nav-link" href="#step-4">
                        <?= Yii::t('app', 'Last Step') ?>
                        <br><?= Yii::t('app', 'Save And Publish') ?>
                    </a>
                </li>
            </ul>


            <div class="tab-content">

                <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">

                    <?php echo Yii::$app->view->renderFile('@backend/views/takamolat/_ad_license.php', [
                        'model' => $model,
                        'form' => $form
                    ]); ?>

                </div>

                <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                    <?php echo Yii::$app->view->renderFile('@backend/views/takamolat/_step2.php', [
                        'model' => $model,
                        'form' => $form
                    ]); ?>
                </div>

                <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
                    <?php echo Yii::$app->view->renderFile('@backend/views/takamolat/_step3.php', [
                        'model' => $model,
                        'form' => $form,
                        'images' => $images
                    ]); ?>
                </div>

                <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4">
                    <?php echo Yii::$app->view->renderFile('@backend/views/takamolat/_step4.php', [
                        'model' => $model,
                        'form' => $form
                    ]); ?>
                </div>

            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>
    <?php /*Pjax::end();*/ ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
<script src="@web/js/scripts.js" defer></script>

<script>
    window.location.hash = '';

    $(document).ready(function () {

        // $('#step-1 form').validate({
        //
        // });

        // const hashValue = window.location.hash;
        //
        // if (hashValue != "" && hashValue != '#step-1') {
        //     $('#step-1').hide();
        // }

        $('#description').summernote({
            height: 300, // Set the height of the editor
            // Add any other options or callbacks you need
        });

        $('body').on('click', '.button:not(#submit_form)', function () {
            disableButton($(this));
            // $(this).attr('disabled', true).addClass('loading').append('<span class="loading-wrap""><svg class="spinner" fill="#333" viewBox="0 0 50 50"><circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle></svg></span>')
        })

        $(document).ajaxSuccess(function (event, xhr) {
            var forceClose = xhr && xhr.responseJSON;
            if (xhr.responseJSON && xhr.responseJSON.forceClose) {
                $('#smartwizard').smartWizard("loader", "hide");
                $('#smartwizard').smartWizard("next");
            }
        });

        // $(document).ajaxComplete(function (event, xhr) {
        //     // $('#smartwizard').smartWizard("loader", "hide");
        //     $('#smartwizard').smartWizard("loader", "show");
        // });
        // modal = new ModalRemote('#ajaxCrubModal');
        //
        // checkOrAdd = function(){
        //
        $("body").on("click", ".loadMainContent", function (event) {
            event.preventDefault();

            const step = $(this).parents('.tab-pane');

            // $(this).attr('disabled', false).removeClass('loading').find('span').remove();
            enableButton($(this))

            $('html, body').animate({scrollTop: 0}, 800);

            const checkValidation = checkRequiredFields(step);

            if (checkValidation) {
                $('#smartwizard').smartWizard("loader", "show");
                $('#smartwizard').smartWizard("next");
                $('#smartwizard').smartWizard("loader", "hide");
            }

        });
        //
        //         $('#smartwizard').smartWizard("loader", "show");
        //
        //         var form = $( this ).parent().parent();
        //         var formData = form.serialize();
        //
        //         $.ajax({
        //             url: form.attr("action"),
        //             type: form.attr("method"),
        //             data: formData,
        //             success: function (data) {
        //                 $('#smartwizard').smartWizard("next");
        //
        //                 $('#smartwizard').smartWizard("loader", "hide");
        //
        //                 // if(data.error == true)
        //                 // {
        //                 //     modal.show();
        //                 //
        //                 //     if (data.forceReload !== undefined && data.forceReload) {
        //                 //         if (data.forceReload == 'true') {
        //                 //             // Backwards compatible reload of fixed crud-datatable-pjax
        //                 //             $.pjax.reload({container: '#crud-datatable-pjax'});
        //                 //         } else {
        //                 //             $.pjax.reload({container: data.forceReload});
        //                 //         }
        //                 //     }
        //                 //
        //                 //     // Close modal if data contains forceClose field
        //                 //     if (data.forceClose !== undefined && data.forceClose) {
        //                 //         modal.hide();
        //                 //         return;
        //                 //     }
        //                 //
        //                 //     if (data.size !== undefined)
        //                 //         modal.setSize(data.size);
        //                 //
        //                 //     if (data.title !== undefined)
        //                 //         modal.setTitle(data.title);
        //                 //
        //                 //     if (data.content !== undefined)
        //                 //         modal.setContent(data.content);
        //                 //
        //                 //     if (data.footer !== undefined)
        //                 //         modal.setFooter(data.footer);
        //                 //
        //                 //     if ($(modal.content).find("form")[0] !== undefined) {
        //                 //         modal.setupFormSubmit(
        //                 //             $(modal.content).find("form")[0],
        //                 //             $(modal.footer).find('[type="submit"]')[0]
        //                 //         );
        //                 //     }
        //                 //
        //                 //     $('#smartwizard').smartWizard("loader", "hide");
        //                 //
        //                 //     // ModalRemote
        //                 //     // modal.beforeRemoteRequest();
        //                 //     // modal.successRemoteResponse(data);
        //                 //     // modal.doRemote(form.attr("action"), form.attr("method"),null);
        //                 // }else if(data.error == false){
        //                 //
        //                 //     $('#smartwizard').smartWizard("next");
        //                 // }else{
        //                 //     console.log("else");
        //                 //     $('#smartwizard').smartWizard("loader", "hide");
        //                 // }
        //
        //             },
        //             error: function () {
        //                 alert("Something went wrong");
        //             }
        //         });
        //     });
        // }

        // Initialize the leaveStep event
        $("#smartwizard").on("leaveStep", function (e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
            // return $('#step-1 form').validate().form();

            // enableButton($('.loadMainContent'));
            //
            // const currentStepForm = $('#step-' + (currentStepIndex+1));
            // const checkValidation = checkRequiredFields(currentStepForm);
            //
            // if (checkValidation) {
            //     $('html, body').animate({scrollTop: 0}, 800);
            // }

            // return checkValidation;
        });

        // SmartWizard initialize
        $('#smartwizard').smartWizard({
            theme: 'arrows',
            showStepURLhash: false,
            justified: true,
            autoAdjustHeight: false,
            enableUrlHash: false,
            selected: window.location.hash || 0,
            // onLeaveStep: function(obj, context) {
            // var stepIndex = context.fromStep;  // Get the index of the current step
            //
            // alert('data');
            // // Perform asynchronous validation
            // return true;
            // }
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
            // onFinish: function () {
            //     $('#form_takamolat').submit(); // Submit the form on finish
            // }
        });


        // Function to validate the form in a given step
        function validateForm(stepIndex) {
            // Get the form in the current step
            var currentStepForm = $('#step-' + stepIndex);

            // Use jQuery Validation Plugin to validate the form
            if (currentStepForm.valid()) {
                // Additional custom validation for required fields
                return checkRequiredFields(currentStepForm);
            } else {
                return false; // Form is not valid, prevent navigation
            }
        }

        // Function to check required fields in a form
        function checkRequiredFields(form) {
            let isValid = true;

            // Find all required fields in the form
            form.find('[required]').each(function () {
                var input = $(this);

                // Check if the required field is filled
                if ($.trim(input.val()) === '') {
                    // If not filled, mark as invalid and set isValid to false
                    input.parents('.form-group').addClass('required').addClass('has-error'); // You can customize the styling
                    isValid = false;

                } else {
                    input.removeClass('error'); // Clear any previous error styling
                }
            });

            return isValid;
        }

        // $('#submit_form').on('click', function (e) {
        //     e.preventDefault();
        //     $(this).parents('form').submit();
        // });
    });
</script>