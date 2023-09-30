 <?php 
 use yii\helpers\Html;
 use yii\helpers\Url;
 ?>
 <div class="timeline-badge  box box-primary">
               
            <div class="timeline-body  table-responsive">
                <div class="timeline-body-head col-sm-10 ">
                    <div class="timeline-body-head-caption ">
                        <a href="<?=Url::to(['user/update', 'id' =>$model->id])?>" class="timeline-body-title font-blue-madison"><?=$model->name?></a>
                        <span class="timeline-body-time font-grey-cascade"><?=Yii::t('app','date of registration : ')?> <?= Yii::$app->formatter->asDate($model->created_at, 'php:Y/m/d');?></span>
                    </div>
                    <div class="timeline-body-head-actions ">
                        <div class="btn-group " >
                            <a href="<?=Url::to(['user/update', 'id' =>$model->id])?>" class="btn btn-circle green-haze btn-sm dropdown-toggle" >
                            <?=Yii::t('app','Update')?> 
                            </a>
                            
                             <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
								'class' => 'btn btn-circle  btn-sm dropdown-toggle btn btn-danger margin_right_5',
								'data' => [
									'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
									'method' => 'post',
								],
							]) ?>
                           
                        </div>
                    </div>
                </div>
                <div class="timeline-body-content " >
                    <span class="font-grey-cascade">
                    <div class="col-sm-4"><i class="fa fa-address-card" aria-hidden="true"></i> <span style="color:#1caf9a;font-size:16px"><?=Yii::t('app','Account Status :')?></span> <?php if($model->status==0){echo Yii::t('app','Not Active');}else{ echo Yii::t('app','Active');} ?></div>
                    
                     <div class="col-sm-4"><i class="fa fa-location-arrow"></i> <span style="color:#1caf9a;font-size:16px"><?=Yii::t('app','Email :')?></span> <?=$model->email?> </div>

                    </span>
                </div>
            </div>
</div>
