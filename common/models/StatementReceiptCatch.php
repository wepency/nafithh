<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "statement_receipt_catch".
 *
 * @property int $id
 * @property float|null $amount_paid المبلغ المدفوع
 * @property int $estate_office_id
 * @property int $owner_id
 * @property string|null $detail
 * @property string|null $detail_en
 * @property string|null $created_date
 */
class StatementReceiptCatch extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'statement_receipt_catch';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount_paid'], 'number'],
            [['estate_office_id', 'owner_id'], 'required'],
            [['estate_office_id', 'owner_id'], 'integer'],
            [['detail', 'detail_en'], 'string'],
            [['created_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'amount_paid' => Yii::t('app', 'Amount Paid'),
            'estate_office_id' => Yii::t('app', 'Estate Office ID'),
            'owner_id' => Yii::t('app', 'Owner ID'),
            'detail' => Yii::t('app', 'Detail'),
            'detail_en' => Yii::t('app', 'Detail En'),
            'created_date' => Yii::t('app', 'Created Date'),
        ];
    }



    public function getOwner()
    {
        return $this->hasOne(User::class, ['id' => 'owner_id']);
    }


    public function getEstateOffice()
    {
        return $this->hasOne(EstateOffice::class, ['id' => 'estate_office_id']);
    }


    public function setDetail($template,$params =[]){
        $text = '';

        switch ($template) {
            case 'brokerage':
                $text_ar = 'مبلغ  ({amount}) عمولة المكتب من العقد  رقم  ({contract_id})تم خصمها من القسط رقم {installment_id}';
                $text = 'amount ({amount}) for Brokerage commission from Contract Id ({contract_id}) by intallment Id ({installment_id})';
                break; 
            case 'maintenance':
                $text_ar = 'مبلغ  ({amount}) تصفية سند صرف الصيانة  ({receipt_voucher_id})';
                $text = 'amount ({amount}) Liquidation of the maintenance receipt voucher ({receipt_voucher_id})';
                break; 
            default:
        }
        $this->detail = yii::t('app',$text,$params,'ar');
        $this->detail_en = yii::t('app',$text,$params,'en');
        $this->detail = yii::t('app',$text_ar,$params,'ar');

    }
}
