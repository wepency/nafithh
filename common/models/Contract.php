<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "contract".
 *
 * @property int $id
 * @property string $contract_no
 * @property int $estate_office_id
 * @property int $owner_id
 * @property int $building_id
 * @property int $housing_unit_id
 * @property int $renter_id
 * @property int $rent_period_id
 * @property int $housing_using_type_id
 * @property int $contract_form_id
 * @property int $user_created_id المستخدم الذي قام بإضافة العقد
 * @property int|null $refrence_contract_id العقد المرجعي إذا كان العقد تمديد لعقد أخر
 * @property string $contract_info_json بيانات العقد مثل بيانات المستأجر أو الوحدة السكنية أو غيره
 * @property string|null $created_date تاريخ إنشاء العقد
 * @property string $start_date
 * @property string $end_date
 * @property float $price
 * @property string|null $price_text
 * @property float|null $added_tax الضريبة المضافة
 * @property float|null $insurance_amount مبلغ التأمين
 * @property int|null $include_water 0=no , 1 yes
 * @property float $water_amount
 * @property int|null $include_electricity 0=no , 1 yes
 * @property int|null $include_maintenance 0=no , 1 yes
 * @property int|null $status 0=close, 1=open // not use now
 * @property int|null $is_active 0=no , 1=yes // if cotract expire or close set value 0
 * @property int|null $is_draft 0=no , 1=yes
 * @property int $number_installments عدد الأقساط
 * @property string|null $details تفاصيل العقد
 * @property string|null $contract_no_ejar
 * @property string|null $file
 * @property string|null $terms_and_conditions تفاصيل العقد
 * @property int|null $brokerage_type 1=percent , 2=static Amount
 * @property int|null $brokerage_value
 *
 * @property Building $building
 * @property ContractFormEstateOffice $contractForm
 * @property EstateOffice $estateOffice
 * @property BuildingHousingUnit $housingUnit
 * @property User $owner
 * @property User $renter
 * @property RentPeriod $rentPeriod
 * @property User $userCreated
 * @property Installment[] $installments
 */
class Contract extends \yii\db\ActiveRecord
{
    public $imageFiles;

    const NOTIF_TEMP_NEAR_EXPIR = 4;
    const EVENT_NEAR_EXPIR = 'eventExpir';
    const EVENT_EXPIRED = 'eventExpired';
    const EVENT_STATEMENT = 'eventCreateStatement';
    const EVENT_MANAGEMENT_STATEMENT = 'eventCreateManagementStatement';
    const EVENT_MARKETING_STATEMENT = 'eventCreateMarketingStatement';

    const NOTIF_TEMP_NEW_FOR_ESTATE = 2;
    const NOTIF_TEMP_NEW_FOR_RENTER = 3;
    const EVENT_NEW = 'eventNew';

    public function init()
    {
        $this->on(self::EVENT_NEW, [$this, self::EVENT_NEW]);
        $this->on(self::EVENT_NEAR_EXPIR, [$this, self::EVENT_NEAR_EXPIR]);
        $this->on(self::EVENT_EXPIRED, [$this, self::EVENT_EXPIRED]);
        $this->on(self::EVENT_STATEMENT, [$this, self::EVENT_STATEMENT]);
        parent::init(); // DON'T Forget to call the parent method.
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contract';
    }

    public static function find()
    {
        return new \common\query\ContractQuery(get_called_class());
    }

    public function behaviors()
    {
        return [

            'polymorphic' => [
                'class' => \common\behaviors\RelatedPolymorphicBehavior::class,
                'polyRelations' => [
                    'attachments' => [
                        'type' => \common\behaviors\RelatedPolymorphicBehavior::HAS_MANY,
                        'class' => Attachment::class,
                        'deleteRelated' => true,
                    ],
                ],
                'polymorphicType' => $this->tableName(),
                'pkColumnName' => 'id',
                'foreignKeyColumnName' => 'item_id',
                'typeColumnName' => 'item_type',
            ],
            'uploadBehavior' =>
                [
                    'class' => \common\behaviors\UploadBehavior::class,
                    'fileAttribute' => 'file',
                    'saveDir' => Yii::getAlias("@upload/contract/")
                ],
//            'convertNumToTextBehavior' => [
//                'class' => \common\behaviors\ConvertNumToTextBehavior::class,
//                // اسم الحقل الذي فيه المبلغ
//                'numberAttribute' => 'price',
//                // اسم الحقل الذي سيضاف إليه المبلغ كنص
//                'textNumberAttribute' => 'price_text'
//            ],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estate_office_id', 'owner_id', 'building_id', 'housing_unit_id', 'renter_id', 'rent_period_id', 'housing_using_type_id', 'user_created_id', 'price', 'number_installments', 'start_date', 'end_date', 'contract_no_ejar', 'brokerage_type', 'brokerage_value'], 'required'],
            [['estate_office_id', 'owner_id', 'building_id', 'housing_unit_id', 'renter_id', 'rent_period_id', 'housing_using_type_id', 'contract_form_id', 'user_created_id', 'refrence_contract_id', 'include_water', 'include_electricity', 'include_maintenance', 'status', 'is_active', 'is_draft', 'brokerage_type', 'marketing_fees_type', 'property_management_fees_type'], 'integer'],
            [['number_installments'], 'integer', 'min' => 1],
            [['brokerage_value', 'marketing_fees', 'property_management_fees'], 'number', 'min' => 0],
            [['contract_info_json', 'details', 'terms_and_conditions', 'water_meter_serial', 'water_account_number', 'meter_reading_number'], 'string'],
            [['created_date', 'start_date', 'end_date'], 'safe'],
            [['price', 'added_tax', 'insurance_amount', 'water_amount'], 'number'],
            [['contract_no_ejar'], 'string', 'max' => 50],
            [['contract_no'], 'string', 'max' => 20],
            [['price_text', 'file'], 'string', 'max' => 200],
            [['building_id'], 'exist', 'skipOnError' => true, 'targetClass' => Building::class, 'targetAttribute' => ['building_id' => 'id']],
            [['contract_form_id'], 'exist', 'skipOnError' => true, 'targetClass' => ContractFormEstateOffice::class, 'targetAttribute' => ['contract_form_id' => 'id']],
            [['estate_office_id'], 'exist', 'skipOnError' => true, 'targetClass' => EstateOffice::class, 'targetAttribute' => ['estate_office_id' => 'id']],
            [['housing_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => BuildingHousingUnit::class, 'targetAttribute' => ['housing_unit_id' => 'id']],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['owner_id' => 'id']],
            [['renter_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['renter_id' => 'id']],
            [['rent_period_id'], 'exist', 'skipOnError' => true, 'targetClass' => RentPeriod::class, 'targetAttribute' => ['rent_period_id' => 'id']],
            [['user_created_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_created_id' => 'id']],
            [['imageFiles', 'file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif, pdf, docx, xlsx', 'mimeTypes' => 'image/jpeg,image/jpg, image/png, image/gif,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'maxFiles' => 10],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'contract_no' => Yii::t('app', 'Contract No'),
            'estate_office_id' => Yii::t('app', 'Estate Office'),
            'owner_id' => Yii::t('app', 'Owner'),
            'building_id' => Yii::t('app', 'Building'),
            'housing_unit_id' => Yii::t('app', 'Housing Unit'),
            'renter_id' => Yii::t('app', 'Renter'),
            'rent_period_id' => Yii::t('app', 'Rent Period'),
            'housing_using_type_id' => Yii::t('app', 'Housing Using Type'),
            'contract_form_id' => Yii::t('app', 'Contract Form'),
            'user_created_id' => Yii::t('app', 'User Created'),
            'refrence_contract_id' => Yii::t('app', 'Refrence Contract'),
            'contract_info_json' => Yii::t('app', 'Contract Info Json'),
            'created_date' => Yii::t('app', 'Created Date'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
            'price' => Yii::t('app', 'Price'),
            'price_text' => Yii::t('app', 'Price Text'),
            'added_tax' => Yii::t('app', 'Added Tax'),
            'insurance_amount' => Yii::t('app', 'Insurance Amount'),
            'include_water' => Yii::t('app', 'Include Water'),
            'include_electricity' => Yii::t('app', 'Include Electricity'),
            'include_maintenance' => Yii::t('app', 'Include Maintenance'),
            'status' => Yii::t('app', 'Status'),
            'is_active' => Yii::t('app', 'Is Active'),
            'is_draft' => Yii::t('app', 'Is Draft'),
            'number_installments' => Yii::t('app', 'Number Installments'),
            'details' => Yii::t('app', 'Details'),
            'terms_and_conditions' => Yii::t('app', 'Terms And Conditions'),
            'water_amount' => Yii::t('app', 'Water Amount'),
            'contract_no_ejar' => Yii::t('app', 'Ejar Contract No'),
            'file' => Yii::t('app', 'Additional File'),
            'brokerage_type' => Yii::t('app', 'Brokerage Type'),
            'brokerage_value' => Yii::t('app', 'Brokerage Value'),

            'water_meter_serial' => Yii::t('app', 'Water Meter Serial'),
            'water_account_number' => Yii::t('app', 'Water Account Number'),
            'meter_reading_number' => Yii::t('app', 'Meter Reading Number'),
        ];
    }


    /**
     * Gets query for [[Building]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBuilding()
    {
        return $this->hasOne(Building::class, ['id' => 'building_id']);
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        // [['rent_period_id', 'housing_using_type_id', 'contract_form_id', 'price', 'number_installments', 'start_date', 'end_date'], 'required'],
        $scenarios['draft'] = ['estate_office_id', 'owner_id', 'building_id', 'housing_unit_id', 'renter_id', 'user_created_id', 'rent_period_id', 'housing_using_type_id', 'contract_form_id'];
        // $scenarios['updateuserorder'] = ['username','email','name','mobile','address','description'];
        return $scenarios;
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $result = ($this->installments) ? 'Installments' : null;
            if ($result !== null) {
                Yii::$app->session->setFlash('danger',
                    yii::t('app', 'cannot delete {item} has items from {items}.', [
                        'item' => yii::t('app', 'Contract'), 'items' => yii::t('app', $result)
                    ])
                );
                return false;
            }

//            $housingUnit = $this->getHousingUnit();
//            if ($housingUnit !== NULL) {
//                $housingUnit->status = 0;
//
//                if (!$housingUnit->save()) {
//                    Yii::$app->session->setFlash('danger', Yii::t('app', 'Failed to update the housing unit status.'));
//                    return false;
//                }
//
//            }
            Yii::$app->session->setFlash('success', Yii::t('app', 'Deletes are done successfully.'));
            return true;
        }
        return false;
    }

    /**
     * Gets query for [[ContractForm]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContractForm()
    {
        return $this->hasOne(ContractFormEstateOffice::class, ['id' => 'contract_form_id']);
    }

    /**
     * Gets query for [[EstateOffice]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEstateOffice()
    {
        return $this->hasOne(EstateOffice::class, ['id' => 'estate_office_id']);
    }

    /**
     * Gets query for [[HousingUnit]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHousingUnit()
    {
        return $this->hasOne(BuildingHousingUnit::class, ['id' => 'housing_unit_id']);
    }

    public function getHousingUsingType()
    {
        return $this->hasOne(HousingUsingType::class, ['id' => 'housing_using_type_id']);
    }

    /**
     * Gets query for [[Owner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::class, ['id' => 'owner_id']);
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

    /**
     * Gets query for [[RentPeriod]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRentPeriod()
    {
        return $this->hasOne(RentPeriod::class, ['id' => 'rent_period_id']);
    }

    /**
     * Gets query for [[UserCreated]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCreated()
    {
        return $this->hasOne(User::class, ['id' => 'user_created_id']);
    }

    /**
     * Gets query for [[Installments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInstallments()
    {
        return $this->hasMany(Installment::class, ['contract_id' => 'id']);
    }

    public function eventNew($event)
    {
        $this->refresh();
        // FOR ESTATE OFFICE
        $params = [
            're_id' => $this->estate_office_id,
            're_type' => 'estate_officer',
            'content' => 'New Contract Added successfully.',
            'id' => $this->id,
            't_name' => 'contract',
            'mobile' => $this->estateOffice->mobile,
            'email' => $this->estateOffice->email,

            'estate_office_name' => $this->estateOffice->name,
            'renter_name' => $this->renter->name,
            'created_date' => $this->created_date,
        ];
        \common\components\GeneralHelpers::sendNotif(self::NOTIF_TEMP_NEW_FOR_ESTATE, $params, $this->estateOffice->id);
        // FOR RENTER
        $params = [
            're_id' => $this->renter_id,
            're_type' => 'renter',
            'content' => 'New Contract Added successfully.',
            'id' => $this->id,
            't_name' => 'contract',
            'mobile' => $this->renter->mobile,
            'email' => $this->renter->email,

            'estate_office_name' => $this->estateOffice->name,
            'renter_name' => $this->renter->name,
            'created_date' => $this->created_date,
        ];

        \common\components\GeneralHelpers::sendNotif(self::NOTIF_TEMP_NEW_FOR_RENTER, $params, $this->estateOffice->id);
    }

    public function eventExpir($event)
    {

        // $model->trigger(Contract::EVENT_NEAR_EXPIR); 
        if (!isset($this->renter->mobile) || !isset($this->housingUnit->housing_unit_name)) {
            return '';

        }
        // FOR RENTER
        $params = [
            're_id' => $this->renter_id,
            're_type' => 'renter',
            'content' => 'your Contract is Remaining expire',
            'id' => $this->id,
            't_name' => 'contract',
            'mobile' => $this->renter->mobile,
            'email' => $this->renter->email,

            'housing_name' => $this->housingUnit->housing_unit_name,
            'renter_name' => $this->renter->name,
            'end_date' => $this->end_date,
        ];

        \common\components\GeneralHelpers::sendNotif(self::NOTIF_TEMP_NEAR_EXPIR, $params, $this->estateOffice->id);
    }


    public function eventExpired($event)
    {

        if ($this->is_active === 1) {
            $this->housingUnit->status = 0;
            $this->housingUnit->save();

            $installments = Installment::find()->where(['contract_id' => $this->id, 'payment_status' => Installment::STATUS_UNPAID])->all();
            foreach ($installments as $row) {
                $row->details = $row->details . ' ' . yii::t('app', "The Installment has been cancelled") . ' ' . yii::t('app', 'becouse the contract expired');
                $row->payment_status = Installment::STATUS_CANCEL;
                $row->save(false);
            }
            $this->end_date = date('Y-m-d', \time());

            $this->is_active = 0;
//            $this->details = $this->details . ' ' . yii::t('app', 'change expire date') . ' ' . yii::t('app', 'becouse the contract expired');
            $this->details = "";
            $this->save(false);
        }

    }

    public function eventCreateStatement($event)
    {

        $amount = 0;

        if ($this->brokerage_type == 1) {
            $brokerage_percent = $this->brokerage_value;
            $amount = ($brokerage_percent * $this->price) / 100;
        } else {
            $amount = $this->brokerage_value;
        }

        $trans = new Statement();

        $trans->housing_id = $this->housing_unit_id;
        $trans->building_id = $this->building_id;
        $trans->estate_office_id = $this->estate_office_id;
        $trans->owner_id = $this->owner_id;
        $trans->contract_id = $this->id;
        $trans->type = 1;
        $trans->subtype = 'brokerage';

        // $trans->debit = ;
        $trans->credit = $amount;
        // $trans->reference_id = ;
        $trans->setDetail('brokerage', ['amount' => $amount, 'contract_id' => $this->id]);
        $trans->save();

        $this->eventCreateManagementStatement($event);
        $this->eventCreateMarketingStatement($event);
    }

    public function eventCreateManagementStatement($event)
    {

        $amount = 0;

        if ($this->property_management_fees > 0) {

            if ($this->property_management_fees_type == 1) {

                $management_fees_percent = $this->property_management_fees;
                $amount = ($management_fees_percent * $this->price) / 100;

            } else {

                $amount = $this->property_management_fees;

            }

            $trans = new Statement();

            $trans->housing_id = $this->housing_unit_id;
            $trans->building_id = $this->building_id;
            $trans->estate_office_id = $this->estate_office_id;
            $trans->owner_id = $this->owner_id;
            $trans->contract_id = $this->id;
            $trans->type = 1;
            $trans->subtype = 'management';

            // $trans->debit = ;
            $trans->credit = $amount;
            // $trans->reference_id = ;
            $trans->setDetail('management', ['amount' => $amount, 'contract_id' => $this->id]);
            $trans->save();
        }
    }

    public function eventCreateMarketingStatement($event)
    {

        $amount = 0;

        if ($this->marketing_fees > 0) {
            if ($this->marketing_fees_type == 1) {
                $marketing_percent = $this->marketing_fees;
                $amount = ($marketing_percent * $this->price) / 100;
            } else {
                $amount = $this->marketing_fees;

            }

            $trans = new Statement();

            $trans->housing_id = $this->housing_unit_id;
            $trans->building_id = $this->building_id;
            $trans->estate_office_id = $this->estate_office_id;
            $trans->owner_id = $this->owner_id;
            $trans->contract_id = $this->id;
            $trans->type = 1;
            $trans->subtype = 'marketing';

            // $trans->debit = ;
            $trans->credit = $amount;
            // $trans->reference_id = ;
            $trans->setDetail('marketing', ['amount' => $amount, 'contract_id' => $this->id]);
            $trans->save();
        }

    }

    // public function eventExpired($event){

    //   $now = strtotime(date('Y-m-d', \time())." 23:59:59");
    //   $expireContract = strtotime(date('Y-m-d', strtotime($this->end_date))." 00:00:00");
    //   // print_r($now); die();
    //   // print_r(date('Y-m-d H:i:s', $expireContract)); die();
    //   // إذا انتهى العقد انتهاء طبيعي 
    //   if($now > $expireContract ){
    //     $this->housingUnit->status = 0;
    //     $this->housingUnit->save();
    //   }else{
    //     // إذا تم إنهاء العقد يدويا قبل موعده يتم تصفير الأقساط
    //     $installments = Installment::find()->where(['contract_id' => $this->id , 'payment_status' =>Installment::STATUS_PART_PAID ])->all();
    //     foreach ($installments as $row ) {
    //       $row->details = $row->details.' '.yii::t('app',"set amount ({amount}) to zero",['amount'=>$row->amount]).' '.yii::t('app','becouse the contract expired');
    //       $row->amount = 0;
    //       $row->save(false);
    //     }
    //     $this->end_date = date('Y-m-d', \time());

    //   }
    //   $this->status = 0;
    //   $this->details = $this->details.' '.yii::t('app','change expire date').' '.yii::t('app','becouse the contract expired');
    //   $this->save();

    // }


}
