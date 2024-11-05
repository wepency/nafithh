<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "installment".
 *
 * @property int $id
 * @property int $contract_id
 * @property int $renter_id
 * @property string $installment_no رقم القسط
 * @property int|null $payment_status {0= no paid , 2= paid , 1=part was paid ,3=>cancelled}
 * @property int|null $payment_status_owner {0= no paid , 2= paid , 1=part was paid ,3=>cancelled}
 * @property float $amount
 * @property string|null $amount_text
 * @property float|null $amount_paid المبلغ المدفوع
 * @property float|null $amount_remaining المبلغ المتبقي
 * @property float|null $amount_remaining_owner المبلغ المتبقي  للمالك
 * @property string|null $details
 * @property string $start_date
 * @property string $end_date
 *
 * @property Contract $contract
 * @property User $renter
 * @property InstallmentReceiptCatch[] $installmentReceiptCatches
 */
class Installment extends \yii\db\ActiveRecord
{
    const STATUS_UNPAID = 0;
    const STATUS_PART_PAID = 1;
    const STATUS_PAID = 2;
    const STATUS_CANCEL = 3;

    const NOTIF_TEMP_NEAR_PAYMENT_RENTER = 5;
    const NOTIF_TEMP_NEAR_PAYMENT_ESTATE = 6;
    const EVENT_NEAR_PAYMENT = 'eventNearPayment';
    const EVENT_STATEMENT = 'eventCreateStatement';
    const EVENT_STATEMENT_OWNER = 'eventCreateStatementOwner';


    const NOTIF_TEMP_NEAR_EXPIR = 7;
    const EVENT_NEAR_EXPIR = 'eventNearExpir';

    public function init(){
      $this->on(self::EVENT_NEAR_PAYMENT, [$this, self::EVENT_NEAR_PAYMENT]);
      $this->on(self::EVENT_NEAR_EXPIR, [$this, self::EVENT_NEAR_EXPIR]);
      $this->on(self::EVENT_STATEMENT, [$this, self::EVENT_STATEMENT]);
      $this->on(self::EVENT_STATEMENT_OWNER, [$this, self::EVENT_STATEMENT_OWNER]);
      parent::init(); // DON'T Forget to call the parent method.
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'installment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contract_id', 'renter_id', 'installment_no', 'amount', 'start_date', 'end_date'], 'required'],
            [['contract_id', 'renter_id', 'payment_status','payment_status_owner'], 'integer'],
            [['amount', 'amount_paid', 'amount_remaining','amount_remaining_owner'], 'number'],
            [[ 'amount_remaining'], 'default','value' => $this->amount ],
            [['details'], 'string'],
            [['start_date', 'end_date'], 'safe'],
            [['installment_no'], 'string', 'max' => 20],
            [['amount_text'], 'string', 'max' => 200],
            [['contract_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contract::class, 'targetAttribute' => ['contract_id' => 'id'],'filter' => function (\common\query\ContractQuery $query) {
                    $query->withDraft();
                }],
            [['renter_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['renter_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'contract_id' => Yii::t('app', 'Contract No'),
            'renter_id' => Yii::t('app', 'Renter'),
            'installment_no' => Yii::t('app', 'Installment'),
            'payment_status' => Yii::t('app', 'Payment Status'),
            'payment_status_owner' => Yii::t('app', 'Payment Status Owner'),
            'amount' => Yii::t('app', 'Amount'),
            'amount_text' => Yii::t('app', 'amount in letters'),
            'amount_paid' => Yii::t('app', 'Received amount'),
            'amount_remaining' => Yii::t('app', 'Remaining amount'),
            'amount_remaining_owner' => Yii::t('app', 'Remaining amount Owner'),
            'details' => Yii::t('app', 'Other Details'),
            'start_date' => Yii::t('app', 'Installment Start Date'),
            'end_date' => Yii::t('app', 'Installment End Date'),
        ];
    }
    
     /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            
            'convertNumToTextBehavior' =>  [ 
                'class' => \common\behaviors\ConvertNumToTextBehavior::class, 
                // اسم الحقل الذي فيه المبلغ
                'numberAttribute' => 'amount',
                // اسم الحقل الذي سيضاف إليه المبلغ كنص
                'textNumberAttribute' => 'amount_text'
            ],  
        ];
    }

    /**
     * Gets query for [[Contract]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContract()
    {
        return $this->hasOne(Contract::class, ['id' => 'contract_id']);
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $result = ($this->installmentReceiptCatches)? 'Installment Receipt Catches': null;  
            if($result !== null){
                Yii::$app->session->setFlash('danger',
                  yii::t('app','cannot delete {item} has items from {items}.',[
                    'item' =>yii::t('app','Installment') ,'items' => yii::t('app',$result)
                  ])
                );
                return false;
            }

            Yii::$app->session->setFlash('success', Yii::t('app','Deletes are done successfully.'));
            return true;
        } 
        return false;
    }
    /**
     * Gets query for [[Renter]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRenter()
    {
        return $this->hasOne(User::class, ['id' => 'renter_id']);
    }

    public function isPaid()
    {
        return ($this->payment_status === $this::STATUS_PAID )? true:false;
    }

    public function isCancelled()
    {
        return ($this->payment_status === $this::STATUS_CANCEL )? true:false;
    }



    /**
     * Gets query for [[InstallmentReceiptCatches]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInstallmentReceiptCatches()
    {
        return $this->hasMany(InstallmentReceiptCatch::class, ['installment_id' => 'id']);
    }


    public function eventNearPayment($event){

        if(!isset($this->renter->mobile) || !isset($this->contract->estateOffice->mobile) ){
            return '';

        }
        $params = [
            're_id' => $this->renter_id ,
            're_type' => 'renter' ,
            'content' => 'You must pay the premium installment' ,
            'id' => $this->id,
            't_name' => 'installment',
            'mobile' => $this->renter->mobile,
            'email' => $this->renter->email,
            
            'renter_name' => $this->renter->name,
            'start_date' => $this->start_date,
            'amount' => $this->amount,
        ];
        \common\components\GeneralHelpers::sendNotif(self::NOTIF_TEMP_NEAR_PAYMENT_RENTER,$params,$this->contract->estate_office_id);
        
        $params = [
            're_id' => $this->contract->estate_office_id ,
            're_type' => 'estate_officer' ,
            'content' => 'There is an installment that is time to pay it' ,
            'id' => $this->id,
            't_name' => 'installment',
            'mobile' => $this->contract->estateOffice->mobile,
            'email' => $this->contract->estateOffice->email,
            
            'renter_name' => $this->renter->name,
            'start_date' => $this->start_date,
            'amount' => $this->amount,
        ];

        \common\components\GeneralHelpers::sendNotif(self::NOTIF_TEMP_NEAR_PAYMENT_ESTATE,$params,$this->contract->estate_office_id);
    }


    public function eventNearExpir($event){

        if(!isset($this->renter->mobile) ){
            return '';
        }
        $params = [
            're_id' => $this->renter_id ,
            're_type' => 'renter' ,
            'content' => 'End of installment deadline' ,
            'id' => $this->id,
            't_name' => 'installment',
            'mobile' => $this->renter->mobile,
            'email' => $this->renter->email,
            
            'renter_name' => $this->renter->name,
            'end_date' => $this->end_date,
            'amount' => $this->amount,
        ];
        \common\components\GeneralHelpers::sendNotif(self::NOTIF_TEMP_NEAR_EXPIR,$params,$this->contract->estate_office_id);
    }


    public function eventCreateStatement($event){
        $contract = $this->contract;
        $st_type1 = Statement::find()->where([
            'contract_id'=>$contract->id,
            'type'=>1,
            ]);

        $stdCredit = (clone $st_type1)->sum('credit');
        $st_type1 = $st_type1->orderBy('id DESC')->all();

        // $amount = $this->amount;
        // if($this->payment_status_owner == self::STATUS_PAID){
        //    return 0; 
        // }elseif($this->payment_status_owner == self::STATUS_PART_PAID){
        //     $amount = $this->amount_remaining_owner;
        // }

        if($st_type1 && ($brokerage = $stdCredit) >= 0 ){

        // إذا كان يوجد قيد بنوع عمولة لنفس هذا العقد 
            $st_type5 = Statement::find()
            ->select('sum(debit) as sum')
            ->where([
            'contract_id'=>$contract->id,
            'type'=>5,
            ])->andWhere(['>','id',$st_type1[0]->id])->orderBy('id ASC')->asArray()->One();

            // print_r($brokerage); die();
            if($brokerage > $st_type5['sum'] ){
            // إذا كانت عمولة المكتب أكبر من مجموع القيود يعني أن المكتب لم يستلم كامل المبلغ
                $brokerage_remaining = $brokerage - ($st_type5['sum'] ??  0);

                if($brokerage_remaining >= $this->amount){
                    // إذا كان المبلغ المتبقي للمالك أكبر من القسط يتم إضافة  قيد على المكتب وسند قبض
                    // يتم تحديد القسط أنه مسدد بشكل كامل للمالك
                    $this->payment_status_owner = self::STATUS_PAID;
                    $amount = $this->amount;
                }else{
                    // إذا كان المتبقي للمكتب أقل من القسط , سيتم إضافة قيد على المكتب وسند قبض وإضافة بقية المبلغ للمالك
                    // يتم تحديد القسط أنه مسدد منه جزء للمالك
                    $this->payment_status_owner = self::STATUS_PART_PAID;
                    $amount = $brokerage_remaining;
                    $this->amount_remaining_owner = $this->amount - $amount;
                }

                $receiptCatch = New StatementReceiptCatch();
                $receiptCatch->amount_paid = $amount;
                $receiptCatch->estate_office_id = $contract->estate_office_id;
                $receiptCatch->owner_id = $contract->owner_id;
                $receiptCatch->setDetail('brokerage', ['amount'=> $amount,'contract_id'=>$contract->id,'installment_id'=>$this->id]);
                $receiptCatch->save();
                $receiptCatch->refresh();

                $trans = new Statement();
                $trans->housing_id = $contract->housing_unit_id ;
                $trans->building_id = $contract->building_id;
                $trans->estate_office_id = $contract->estate_office_id;
                $trans->owner_id = $contract->owner_id;
                $trans->contract_id = $contract->id;
                $trans->type = 5;

                $trans->debit = $amount;
                // $trans->credit = ;

                $trans->reference_id = $receiptCatch->id;
                $trans->setDetail('receipt_catch',['amount'=> $amount,'receipt_catch_id'=>$receiptCatch->id]);
                $trans->save();
            }else{
                // إذا كانت عمولة المكتب أقل من أو يساوي مجموع القيود بمعنى تم سداد عمولة المكتب بشكل كامل
            }

            $amount = 0;

            $trans = new Statement();
            $trans->housing_id = $contract->housing_unit_id ;
            $trans->building_id = $contract->building_id;
            $trans->estate_office_id = $contract->estate_office_id;
            $trans->owner_id = $contract->owner_id;
            $trans->contract_id = $contract->id;
            $trans->type = 2;

            $trans->reference_id = $this->id;

            if($this->payment_status_owner == self::STATUS_UNPAID){
                $amount = $this->amount;
            }elseif($this->payment_status_owner == self::STATUS_PART_PAID){
                $amount = $this->amount_remaining_owner;
                // $this->amount_remaining_owner = null;
            }else{
                return 0;
            }

            // $this->payment_status_owner = self::STATUS_PAID;

            $trans->setDetail('installment', ['amount'=> $amount,'installment_id'=>$this->id]);

            $trans->debit = $amount;
            $trans->save();
        }
    }


    public function createStatementOwner($amount,$receipt_voucher_id){

        $contract = $this->contract;
        $trans = new Statement();
        $trans->housing_id = $contract->housing_unit_id ;
        $trans->building_id = $contract->building_id;
        $trans->estate_office_id = $contract->estate_office_id;
        $trans->owner_id = $contract->owner_id;
        $trans->contract_id = $contract->id;
        $trans->type = 4;
        $trans->reference_id = $receipt_voucher_id;

        $trans->setDetail('receipt',['amount'=> $amount,'installment_id'=>$this->id,'receipt_voucher_id'=>$receipt_voucher_id]);

        $trans->credit = $amount;
        $trans->save();

    }
}