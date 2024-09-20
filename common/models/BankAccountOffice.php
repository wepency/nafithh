<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bank_account_office".
 *
 * @property int $id
 * @property int $estate_office_id
 * @property string $bank_name
 * @property string $bank_name_en
 * @property string $logo
 * @property string $account_number
 * @property string $owner_account_name
 * @property string $owner_account_name_en
 * @property string $iban
 * @property int $status
 */
class BankAccountOffice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bank_account_office';
    }
	
	public function behaviors()
    {
        return [
            'uploadBehavior' => 
				[
					'class' => \common\behaviors\UploadBehavior::class,
					'fileAttribute' => 'logo',
					'saveDir' => Yii::getAlias("@upload/bank_account_office/")
				],
			[
                'class' => 'yii\behaviors\BlameableBehavior',
                'attributes' =>
                    [
                        \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => 'estate_office_id',
                    ],
				'value' => function(){
					return \common\components\GeneralHelpers::getEstateOfficeId();
					
				}
            ],	
        ];
    }
    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bank_name', 'bank_name_en', 'account_number', 'owner_account_name', 'owner_account_name_en', 'iban', 'status'], 'required'],
            [['estate_office_id', 'status'], 'integer'],
            ['estate_office_id', 'safe'],
            [['bank_name', 'bank_name_en'], 'string', 'max' => 70],
            [['logo', 'owner_account_name', 'owner_account_name_en'], 'string', 'max' => 100],
            [['account_number'], 'string', 'max' => 50],
            [['iban'], 'string', 'max' => 80],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'estate_office_id' => Yii::t('app', 'Estate Office'),
            'bank_name' => Yii::t('app', 'Bank Name'),
            'bank_name_en' => Yii::t('app', 'Bank Name En'),
            'logo' => Yii::t('app', 'Logo'),
            'account_number' => Yii::t('app', 'Account Number'),
            'owner_account_name' => Yii::t('app', 'Owner Account Name'),
            'owner_account_name_en' => Yii::t('app', 'Owner Account Name En'),
            'iban' => Yii::t('app', 'Iban'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    public function getEstateOffice()
    {
        return $this->hasOne(EstateOffice::class, ['id' => 'estate_office_id']);
    }
}
