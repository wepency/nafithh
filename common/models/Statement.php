<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "statement".
 *
 * @property int $id
 * @property int|null $housing_id
 * @property int|null $building_id
 * @property float|null $debit
 * @property float $credit
 * @property int|null $type 1=>brokerage , 2 =>installment , 3=>maintenance , 4=>receipt to owner , 5 => receipt Catch to Estate Office (for brokerage or maintenance)
 * @property int|null $reference_id
 * @property int|null $estate_office_id
 * @property int|null $owner_id
 * @property int|null $contract_id
 * @property string|null $instalment_ids
 * @property string|null $detail
 * @property string|null $detail_en
 * @property string $created_date
 * @property string $year
 */
class Statement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'statement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['housing_id', 'building_id', 'type', 'reference_id', 'estate_office_id', 'owner_id', 'contract_id'], 'integer'],
            [['debit', 'credit'], 'number'],
            [['added_to_receipt'], 'boolean'],
            // [['credit'], 'required'],
            [['instalment_ids', 'detail', 'detail_en'], 'string'],
            [['created_date', 'year'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'housing_id' => Yii::t('app', 'Housing Unit'),
            'building_id' => Yii::t('app', 'Building'),
            'debit' => Yii::t('app', 'Debit'),
            'credit' => Yii::t('app', 'Credit'),
            'type' => Yii::t('app', 'Type'),
            'reference_id' => Yii::t('app', 'Reference ID'),
            'estate_office_id' => Yii::t('app', 'Estate Office'),
            'owner_id' => Yii::t('app', 'Owner'),
            'contract_id' => Yii::t('app', 'Contract'),
            'instalment_ids' => Yii::t('app', 'Instalment Ids'),
            'detail' => Yii::t('app', 'Detail'),
            'detail_en' => Yii::t('app', 'Detail En'),
            'created_date' => Yii::t('app', 'Created Date'),
            'year' => Yii::t('app', 'Year'),
        ];
    }


    public function getBuilding()
    {
        return $this->hasOne(Building::class, ['id' => 'building_id']);
    }
    
    public function getHousingUnit()
    {
        return $this->hasOne(BuildingHousingUnit::class, ['id' => 'housing_id']);
    }

    public function getOwner()
    {
        return $this->hasOne(User::class, ['id' => 'owner_id']);
    }


    public function getEstateOffice()
    {
        return $this->hasOne(EstateOffice::class, ['id' => 'estate_office_id']);
    }


    /**
     * {@inheritdoc}
     * @return \common\query\StatementQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\query\StatementQuery(get_called_class());
    }


    public function setDetail($template,$params =[]){
        $text = '';

        switch ($template) {
            case 'brokerage':
                $text_ar = 'مبلغ  ({amount}) عمولة المكتب من العقد  ({contract_id})';
                $text = 'amount ({amount}) for Brokerage commission To ({contract_id})';
                break;
            case 'management':
                $text_ar = 'مبلغ  ({amount}) عمولة ادارة أملاك من العقد  ({contract_id})';
                $text = 'amount ({amount}) for Management commission To ({contract_id})';
                break;
            case 'marketing':
                $text_ar = 'مبلغ  ({amount}) عمولة التسويق من العقد  ({contract_id})';
                $text = 'amount ({amount}) for Marketing commission To ({contract_id})';
                break;
            case 'installment':
                $text_ar = 'مبلغ  ({amount})قيمة  القسط رقم  ({installment_id})';
                $text = 'amount ({amount}) for Installment Id ({installment_id})';
                break;
            case 'receipt':
                $text_ar = 'مبلغ  ({amount}) مستحقات  القسط رقم  ({installment_id})للمالك , بسند صرف رقم ({receipt_voucher_id})';
                $text = 'amount ({amount}) for Installment Id ({installment_id}) To Owner, By Receipt Voucher ({receipt_voucher_id})';
                break;
            case 'maintenance':
                $text_ar = 'مبلغ  ({amount}) سعر  الصيانة  بسند صرف رقم  ({receipt_voucher_id})';
                $text = 'amount ({amount}) Maintenance Price by Receipt Catch Voucher Id ({receipt_voucher_id})';
                break;
            case 'other':
                $text_ar = 'مبلغ  ({amount}) سعر  أخرى  بسند صرف رقم  ({receipt_voucher_id})';
                $text = 'amount ({amount}) Other Price by Receipt Catch Voucher Id ({receipt_voucher_id})';
                break;
            case 'receipt_catch_maintenance':
                $text_ar = 'مبلغ  ({amount})تصفية سند صرف  الصيانة ({receipt_voucher_id})بسند قبض   ({receipt_catch_id})';
                $text = 'amount ({amount}) Liquidation of the maintenance receipt voucher ({receipt_voucher_id}) By Receipt Catch Id ({receipt_catch_id})';
                break;
            case 'receipt_catch':
                $text_ar = 'مبلغ  ({amount}) سداد عمولة المكتب بسند القبض رقم ({receipt_catch_id})';
                $text = 'amount ({amount}) Brokerage commission Paid to Office by Receipt Catch Id ({receipt_catch_id})';
                break;
            
            default:
                // code...
                break;
        }
        $this->detail = yii::t('app',$text,$params,'ar');
        $this->detail_en = yii::t('app',$text,$params,'en');
        $this->detail = yii::t('app',$text_ar,$params,'ar');

    }
}
