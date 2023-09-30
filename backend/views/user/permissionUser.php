<?php
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
?>
<fieldset>
    <legend><?=Yii::t('app','Permissions')?> :</legend>
    <div class='col-sm-12'>
        <ul class="user-access-list">
            <?php foreach ($permission as $key => $val) { ?>
                <li class="pad">
                    <?= "&nbsp;&nbsp;". yii::t('app',Inflector::pluralize(Inflector::camel2words(StringHelper::basename($key))));?>
                </li>

                <?php if(isset($val['items']) && is_array($val['items']) && count($val['items'])>=1){?>
                    <ul>
                        <?php foreach ($val['items'] as $vals){?>
                            <li class="control-sidebar-menu">
                                <?php  echo $form->field($model, 'access[]',
                                    ['template' => '{input}{label}',
                                        'options' => ['tag' => false],
                                        
                                    ])->checkbox([
                                    'checked'=>in_array($vals['key'],(array)$model->access)?true:false ,
                                    'label'=>yii::t('app',Inflector::camel2words($vals['name'])),
                                    'value'=>$vals['key'],
                                    'class'=>" custom-control-input",
                                    'uncheck' => null,

                                ])->label(false); ?>
                              <?php  /* echo Html::checkBox('access[]',
                              in_array($vals['key'],(array)$model->access)?true:false,
                              array('value'=>$vals['key'],'class'=>"custom-control-input"))?>&nbsp;&nbsp;<?php echo yii::t('app',$vals['name'])*/ ?>
                            </li>
                        <?php };?>
                    </ul>
                <?php }; ?>
            <?php }; ?>
        </ul>
    </div>

</fieldset>