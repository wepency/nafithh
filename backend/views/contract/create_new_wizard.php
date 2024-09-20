<?php
use buttflattery\formwizard\FormWizard;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;

use johnitvn\ajaxcrud\CrudAsset; 

CrudAsset::register($this);



$Group = \common\components\GeneralHelpers::listUserAndOfficeByCurrent('renter');
$Group = ArrayHelper::map($Group,'id','id');
// $list = \common\models\User::find()->where(['or',['user_type'=>'renter'],['renter'=>1]])->all();
$list = \common\models\User::find()->where(['id' => $Group])->all();
$list = ArrayHelper::map($list,'id','name');

// print_r($list); die();

$Group1 = \common\components\GeneralHelpers::listUserAndOfficeByCurrent('owner');
$Group1 = ArrayHelper::map($Group1,'id','id');
$list2 = \common\models\User::find()->where(['id' => $Group1])->all();
// $list = \common\models\User::find()->where(['or',['user_type'=>'owner'],['owner'=>1]])->all();
$list2 = ArrayHelper::map($list2,'id','name');

$text = yii::t('app','save As Draft');
    $js = <<< JS
        var mybutton = $( '<button type="button" id="saveAsDraft"></button>' ).text( "$text")
        .addClass( 'btn btn-warning ' ).attr({'data-params':'{"is_draft":true}','data-method':'post'}).on("click",function(e){
            var form = $("form[id$='contract_form']");
            form.data('yiiActiveForm').validated =  true;
            modal = new ModalRemote('#ajaxCrudModal');
            modal.doRemote(form.attr("action"), form.attr("method"),null);
            
        });
    JS;

$this->registerJs($js, yii\web\View::POS_READY);
echo FormWizard::widget([
    'formOptions'=>[
        'id'=>'contract_form',
        'enableClientValidation'=>false,
        'enableAjaxValidation'=>true,
    ],
    'toolbarExtraButtons'=> new \yii\web\JsExpression('[mybutton]'),
    // 'options'=>[

    // ],

    'steps' => [
        [
            'model' => $model,
            'title' => 'Renter',
            'fieldConfig'=>[
                'only'=>[
                    'renter_id'
                ],
                'renter_id'=>[
                    'widget'=> kartik\select2\Select2::class,
                    'options'=>[
                        'data' =>$list,
                        'options'=>['prompt'=>Yii::t('app','Select Renter')]
                    ]
                ]
            ],
            'description' => 'Add your shoots',
            'formInfoText' => 'Fill all fields'
        ],
        [
            'model' => $model,
            'title' => 'Renter',
            'fieldConfig'=>[
                'only'=>[
                    'owner_id'
                ],
                'owner_id'=>[
                    'widget'=> kartik\select2\Select2::class,
                     'options'=>[
                        'data' =>$list2,
                        'options'=>['prompt'=>Yii::t('app','Select Owner')]
                    ]

                ]
            ],
            'description' => 'Add your shoots',
            'formInfoText' => 'Fill all fields'
        ],
    ]
]);
?>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    'size' => Modal::SIZE_LARGE,
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>