<?php

namespace backend\controllers;

use Yii;
use common\models\Statement;
use common\models\ReceiptVoucher;
use common\models\EstateOfficeBuilding;
use common\models\EstateOfficeSearch;
use common\models\EstateOffice;
use common\models\StatementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use common\models\UserSearch;
use common\models\User;
use common\models\Installment;

use yii\helpers\ArrayHelper;


/**
 * StatementController implements the CRUD actions for Statement model.
 */
class StatementController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }



    public function actionListOwner()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,'owner');

        $user = yii::$app->user->identity;
        switch ($user->role) {
            case 'estate_officer':
                $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
                $dataProvider->query->andFilterWhere(['estate_office_id' => $estate_office_id])
                        ->leftJoin('estate_office_building', 'user.id = estate_office_building.owner_id AND estate_office_building.is_active = 1');
                break;
            default:
                # code...
                break;
        }

        return $this->render('list-owner', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionListOffice()
    {
        $searchModel = new EstateOfficeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $user = yii::$app->user->identity;
        switch ($user->role) {
            case 'owner':
                $dataProvider->query->andFilterWhere(['estate_office_building.owner_id' => $user->id])
                        ->leftJoin('estate_office_building', 'estate_office.id = estate_office_building.estate_office_id AND estate_office_building.is_active = 1');
                break;
            default:
                # code...
                break;
        }

        return $this->render('list-office', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Statement models.
     * @return mixed
     */


    public function actionOffice($estate_office_id)
    {    
        $user = yii::$app->user->identity;
        $owner_id = $user->id;
        $officeBuilding = EstateOfficeBuilding::find()->where(['estate_office_id' => $estate_office_id,'owner_id'=>$owner_id,'is_active'=>1])->all();

        if(!in_array($user->role, ['owner','developer']) || $officeBuilding == null ){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $buildingIds = ArrayHelper::map($officeBuilding,'building_id','building_id');

        $andWhere = [
            'contract.owner_id'=> $owner_id,
            'contract.estate_office_id' => $estate_office_id,
            'installment.payment_status' => Installment::STATUS_PAID,
        ];

        $housingList = \common\models\BuildingHousingUnit::find()
        ->where($andWhere)
        ->joinWith(['contract','contract.installments'])
        ->andOnCondition(['IN','installment.payment_status_owner', [Installment::STATUS_UNPAID,Installment::STATUS_PART_PAID]])
        ->andOnCondition($andWhere)->all();


        $searchModel = new StatementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$owner_id,$estate_office_id);

        return $this->render('office', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'office' => $officeBuilding[0]->estateOffice,
            'housingList' => $housingList,
            'buildingIds' => $buildingIds,
        ]);
    }


    public function actionIndex($owner_id)
    {
        $user = yii::$app->user->identity;
        $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
        $officeBuilding = EstateOfficeBuilding::find()->where(['estate_office_id' => $estate_office_id,'owner_id'=>$owner_id,'is_active'=>1])->all();

        if(!in_array($user->role, ['estate_officer','developer']) || $officeBuilding == null ){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $buildingIds = ArrayHelper::map($officeBuilding,'building_id','building_id');
        
        $andWhere = [
            'contract.owner_id'=> $owner_id,
            'contract.estate_office_id' => $estate_office_id,
            'installment.payment_status' => Installment::STATUS_PAID,
        ];

        $housingList = \common\models\BuildingHousingUnit::find()
        ->where($andWhere)
        ->joinWith(['contract','contract.installments'])
        ->andOnCondition(['IN','installment.payment_status_owner', [Installment::STATUS_UNPAID,Installment::STATUS_PART_PAID]])
        ->andOnCondition($andWhere)->all();

        $searchModel = new StatementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$owner_id,$estate_office_id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'owner' => $officeBuilding[0]->owner,
            'housingList' => $housingList,
            'buildingIds' => $buildingIds,
        ]);
    }


    /**
     * Displays a single Statement model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Statement #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button(yii::t('app',"Close"),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    public function actionStatementOwner()
    {   
        $request = Yii::$app->request;
        $messageError = null; 
        $owner_id = $request->get('owner_id',null);
        $housingIds = $request->get('housing_ids',array());

        if($owner_id == null){
            $messageError = Yii::t('yii', 'Missing required parameters: {params}', ['params' => 'owner_id']);
        }

        $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
        $andWhere = [
            'contract.owner_id'=> $owner_id,
            'contract.estate_office_id' => $estate_office_id,
        ];
        // var_dump(array_values($housingIds)); die();

        $housingList = \common\models\BuildingHousingUnit::find()
        ->andFilterWhere(['building_housing_unit.id'=>$housingIds])
        ->andwhere(['installment.payment_status' => Installment::STATUS_PAID])
        ->joinWith(['contract','contract.installments'])
        ->andOnCondition(['IN','installment.payment_status_owner', [Installment::STATUS_UNPAID,Installment::STATUS_PART_PAID]])
        ->andOnCondition($andWhere)
        ->all();

        foreach ($housingList as  $housing) {
            $andWhere = array_merge($andWhere,[
                'contract.housing_unit_id'=>$housing->id,
                'installment.payment_status'=>Installment::STATUS_PAID
            ]);
            // start installment
            $InstallmentPart = Installment::find()
            // ->select('sum(installment.amount_remaining_owner) as sum')
                ->joinWith('contract')
                ->where(['installment.payment_status_owner'=>Installment::STATUS_PART_PAID])
                ->andWhere($andWhere)
                ->all();

                $InstallmentAll = Installment::find()
                // ->select('sum(installment.amount) as sum')
                ->joinWith('contract')
                ->where(['installment.payment_status_owner'=>Installment::STATUS_UNPAID])
                ->andWhere($andWhere)
                ->all();

            $total_installment = (array_sum(ArrayHelper::map($InstallmentPart,'id','amount_remaining_owner')) ?? 0)  + (array_sum(ArrayHelper::map($InstallmentAll,'id','amount')) ?? 0);

            if($total_installment <= 0){

                $messageError = yii::t('app',"not found any installment for paid!, to Housing Unit ({housingName})",['housingName'=>$housing->housing_unit_name.' - '.$housing->id]);
                break;
            }

            // start Receipt Voucher Maintenance

            $receipts = ReceiptVoucher::find()
            // ->select('sum(amount) as sum')
            ->where([
                'estate_office_id' => $estate_office_id,
                'building_housing_unit_id'=>$housing->id,
                'payment_status_estate'=>Installment::STATUS_UNPAID,
                'recipient_type'=>'maintenance_officer',
            ])->all();
            if(!empty($receipts)){

                $total_maintenance = array_sum(ArrayHelper::map($receipts,'id','amount')) ?? 0;

                if($total_maintenance > $total_installment){
                    $messageError = yii::t('app',"Amount Maintenance Receipt Voucher   greater than the total Installments paid to you!, to Housing Unit ({housingName})",['housingName'=>$housing->housing_unit_name.' - '.$housing->id]);
                    break;
                }

        // var_dump($total_installment); die();

                foreach ($receipts as $receipt) {

                    $receiptsAmount = $receipt->amount;

                    foreach ($InstallmentPart as  $installment) {
                        if($receiptsAmount >= $installment->amount_remaining_owner){
                            $amount2 = $installment->amount_remaining_owner;
                            $installment->payment_status_owner = Installment::STATUS_PAID;
                            $installment->amount_remaining_owner = null;
                        }else{
                            $amount2 = $receiptsAmount;
                            $installment->amount_remaining_owner -= $amount2;
                        }

                        $receiptsAmount -= $amount2;
                        $installment->save();

                        if($receiptsAmount <= 0){
                            // $receipt->trigger(ReceiptVoucher::EVENT_STATEMENT_MAINTENANCE); 
                            $receipt->payment_status_estate = Installment::STATUS_PAID;
                            $receipt->save();
                            break;
                        }
                    }

                    foreach ($InstallmentAll as  $installment) {
                        if($receiptsAmount >= $installment->amount){
                            $amount2 = $installment->amount;
                            $installment->payment_status_owner = Installment::STATUS_PAID;
                        }else{
                            $amount2 = $receiptsAmount;
                            $installment->payment_status_owner = Installment::STATUS_PART_PAID;
                            $installment->amount_remaining_owner = $installment->amount - $amount2;
                        }

                        $receiptsAmount -= $amount2;
                        $installment->save();

                        if($receiptsAmount <= 0){
                            // $receipt->trigger(ReceiptVoucher::EVENT_STATEMENT_MAINTENANCE); 
                            $receipt->payment_status_estate = Installment::STATUS_PAID;
                            $receipt->save();
                            break;
                        }
                    }
                }
            }
        }
        Yii::$app->response->format = Response::FORMAT_JSON;

        if($messageError){
            return [
                'title'=> yii::t('app',"Statement"),
                'content'=>'<div class="alert alert-danger alert-dismissable">'.$messageError.'</div>',
                'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
            ];  
        }else{
            return [
                'title'=> yii::t('app',"Statement"),
                'content'=>'<div class="alert alert-success alert-dismissable">'.yii::t('app','Statement Owner has been done successfully').'</div>',
                'footer'=> Html::button(yii::t('app',"Close"),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::a(yii::t('app',"Create Receipt Voucher To Owner"),['/receipt-voucher/create-owner', 'owner_id' => $owner_id,'housing_ids'=>is_array($housingIds) ? array_values($housingIds) : ''],['class'=>'btn btn-primary','target'=>'_blank','data-pjax'=>0])
            ];    

        }
    }

    /**
     * Creates a new Statement model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // public function actionCreate()
    // {
    //     $request = Yii::$app->request;
    //     $model = new Statement();  

    //     if($request->isAjax){
    //         /*
    //         *   Process for ajax request
    //         */
    //         Yii::$app->response->format = Response::FORMAT_JSON;
    //         if($request->isGet){
    //             return [
    //                 'title'=> "Create new Statement",
    //                 'content'=>$this->renderAjax('create', [
    //                     'model' => $model,
    //                 ]),
    //                 'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
    //                             Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
    //             ];         
    //         }else if($model->load($request->post()) && $model->save()){
    //             return [
    //                 'forceReload'=>'#crud-datatable-pjax',
    //                 'title'=> "Create new Statement",
    //                 'content'=>'<span class="text-success">Create Statement success</span>',
    //                 'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
    //                         Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
    //             ];         
    //         }else{           
    //             return [
    //                 'title'=> "Create new Statement",
    //                 'content'=>$this->renderAjax('create', [
    //                     'model' => $model,
    //                 ]),
    //                 'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
    //                             Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
    //             ];         
    //         }
    //     }else{
    //         /*
    //         *   Process for non-ajax request
    //         */
    //         if ($model->load($request->post()) && $model->save()) {
    //             return $this->redirect(['view', 'id' => $model->id]);
    //         } else {
    //             return $this->render('create', [
    //                 'model' => $model,
    //             ]);
    //         }
    //     }
       
    // }

    /**
     * Updates an existing Statement model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    // public function actionUpdate($id)
    // {
    //     $request = Yii::$app->request;
    //     $model = $this->findModel($id);       

    //     if($request->isAjax){
    //         /*
    //         *   Process for ajax request
    //         */
    //         Yii::$app->response->format = Response::FORMAT_JSON;
    //         if($request->isGet){
    //             return [
    //                 'title'=> "Update Statement #".$id,
    //                 'content'=>$this->renderAjax('update', [
    //                     'model' => $model,
    //                 ]),
    //                 'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
    //                             Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
    //             ];         
    //         }else if($model->load($request->post()) && $model->save()){
    //             return [
    //                 'forceReload'=>'#crud-datatable-pjax',
    //                 'title'=> "Statement #".$id,
    //                 'content'=>$this->renderAjax('view', [
    //                     'model' => $model,
    //                 ]),
    //                 'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
    //                         Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
    //             ];    
    //         }else{
    //              return [
    //                 'title'=> "Update Statement #".$id,
    //                 'content'=>$this->renderAjax('update', [
    //                     'model' => $model,
    //                 ]),
    //                 'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
    //                             Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
    //             ];        
    //         }
    //     }else{
    //         /*
    //         *   Process for non-ajax request
    //         */
    //         if ($model->load($request->post()) && $model->save()) {
    //             return $this->redirect(['view', 'id' => $model->id]);
    //         } else {
    //             return $this->render('update', [
    //                 'model' => $model,
    //             ]);
    //         }
    //     }
    // }

    /**
     * Delete an existing Statement model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    // public function actionDelete($id)
    // {
    //     $request = Yii::$app->request;
    //     $this->findModel($id)->delete();

    //     if($request->isAjax){
    //         /*
    //         *   Process for ajax request
    //         */
    //         Yii::$app->response->format = Response::FORMAT_JSON;
    //         return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
    //     }else{
    //         /*
    //         *   Process for non-ajax request
    //         */
    //         return $this->redirect(['index']);
    //     }


    // }

     /**
     * Delete multiple existing Statement model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    // public function actionBulkDelete()
    // {        
    //     $request = Yii::$app->request;
    //     $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
    //     foreach ( $pks as $pk ) {
    //         $model = $this->findModel($pk);
    //         $model->delete();
    //     }

    //     if($request->isAjax){
            
    //         *   Process for ajax request
            
    //         Yii::$app->response->format = Response::FORMAT_JSON;
    //         return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
    //     }else{
    //         /*
    //         *   Process for non-ajax request
    //         */
    //         return $this->redirect(['index']);
    //     }
       
    // }

    /**
     * Finds the Statement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Statement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Statement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
