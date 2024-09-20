<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property int $id
 * @property string $slug
 * @property string $slug_en
 * @property string $site_name
 * @property string $site_name_en
 * @property string $description
 * @property string $description_en
 * @property string $address
 * @property string $address_en
 * @property string $mobile
 * @property string $phone
 * @property string $email_admin
 * @property string $email
 * @property string $facebook
 * @property string $twitter
 * @property string $youtube
 * @property string $linkedin
 * @property string $instagram
 * @property string $lang
 * @property string $lat
 * @property string|null $profile
 * @property string|null $profile_en
 * @property string $tax_number
 * @property string $services_text
 * @property string $services_text_en
 * @property string $partners_text
 * @property string $partners_text_en
 * @property string|null $key_words
 * @property string|null $key_google_map
 * @property string $admin_theme
 * @property int|null $visit_number
 * @property float|null $tax_percent_maintenance_order
 * @property float|null $added_tax
 * @property int|null $contract_default_type 0 => 'Selected Balance',1 => 'Open Balance'
 * @property int|null $contract_default_no
 * @property int|null $contract_default_period
 * @property int|null $sms_default_type 0 => 'Selected Balance',1 => 'Open Balance'
 * @property int|null $sms_default_no
 * @property int|null $sms_default_period
 * @property int|null $contract_maintenance_free_no
 * @property int|null $contract_maintenance_free_period
 * @property int|null $enable_installment_deposit_bank
 * @property int|null $enable_installment_cash
 * @property int|null $enable_installment_pay_card
 * @property int|null $enable_installment_network
 * @property int|null $default_nationality_id
 * @property string $copyright
 * @property string $copyright_en
 * @property string|null $about_image
 * @property string|null $logo
 * @property string|null $logo_footer
 * @property string|null $icon
 * @property string|null $terms_and_conditions
 * @property string|null $terms_and_conditions_en
 * @property string|null $contact_email
 * @property string|null $account_number
 * @property string|null $iban_number
 * @property string|null $bank_name
 */
class Setting extends \yii\db\ActiveRecord
{

    const INSTALLMENT_CASH = 1;
    const INSTALLMENT_DEPOSIT_BANK = 2;
    const STATUS_PAY_CARD = 3;
    const STATUS_NETWORK = 4;

    public $_slug;
    public $_site_name;
    public $_address;
    public $_description;
    public $_services_text;
    public $_partners_text;
    public $_copyright;
    public $_terms_and_conditions;
    /**
     * {@inheritdoc}
     */

    public function behaviors()
    {
        return [
            'uploadBehavior1' => [ 
                'class' =>\common\behaviors\UploadBehavior::class,
                'fileAttribute' => 'profile',
                'saveDir' => Yii::getAlias("@upload/setting/")
            ],
            'uploadBehavior2' => [ 
                'class' =>\common\behaviors\UploadBehavior::class,
                'fileAttribute' => 'profile_en',
                'saveDir' => Yii::getAlias("@upload/setting/")
            ],
            'uploadBehavior3' => [ 
                'class' =>\common\behaviors\UploadBehavior::class,
                'fileAttribute' => 'logo',
                'saveDir' => Yii::getAlias("@upload/setting/")
            ],
            'uploadBehavior4' => [ 
                'class' =>\common\behaviors\UploadBehavior::class,
                'fileAttribute' => 'icon',
                'saveDir' => Yii::getAlias("@upload/setting/")
            ],
            'uploadBehavior5' => [ 
                'class' =>\common\behaviors\UploadBehavior::class,
                'fileAttribute' => 'logo_footer',
                'saveDir' => Yii::getAlias("@upload/setting/")
            ],
            'uploadBehavior6' => [ 
                'class' =>\common\behaviors\UploadBehavior::class,
                'fileAttribute' => 'about_image',
                'saveDir' => Yii::getAlias("@upload/setting/")
            ],
           
        ];
    }
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug', 'slug_en', 'site_name', 'site_name_en', 'description', 'description_en', 'address', 'address_en', 'mobile', 'phone', 'email_admin', 'email', 'facebook', 'twitter', 'youtube', 'linkedin', 'instagram' ,'services_text', 'services_text_en', 'partners_text', 'partners_text_en', 'copyright', 'copyright_en','default_nationality_id','contact_email'], 'required'],
            [['description', 'description_en', 'services_text', 'services_text_en', 'partners_text', 'partners_text_en','terms_and_conditions','terms_and_conditions_en','contact_email'], 'string'],
            [['visit_number', 'contract_default_type','sms_default_type', 'contract_maintenance_free_no', 'contract_maintenance_free_period', 'enable_installment_deposit_bank', 'enable_installment_cash', 'enable_installment_pay_card', 'enable_installment_network'], 'integer'],
            [['tax_percent_maintenance_order', 'added_tax'], 'number'],
            [['slug', 'site_name', 'lang', 'lat', 'about_image', 'logo','logo_footer', 'icon'], 'string', 'max' => 200],
            [['slug_en', 'site_name_en', 'address_en', 'facebook', 'twitter', 'youtube', 'linkedin', 'instagram', 'copyright', 'copyright_en', 'account_number', 'iban_number', 'bank_name'], 'string', 'max' => 255],
            [['default_nationality_id'], 'integer'],
            [['address'], 'string', 'max' => 250],
            [['mobile', 'phone'], 'string', 'max' => 20],
            [['email_admin', 'email'], 'string', 'max' => 100],
            [['profile', 'profile_en'], 'string', 'max' => 150],
            [['tax_number'], 'string', 'max' => 30],
            [['key_words', 'key_google_map'], 'string', 'max' => 500],
            [['admin_theme'], 'string', 'max' => 50],
            [['added_tax','tax_percent_maintenance_order'], 'integer' ,'min' => 0 , 'max' => 100],
            [['contract_default_period','contract_default_no','sms_default_no','sms_default_period'], 'number' ,'min' => 0],
            [['contract_default_period','contract_default_no','sms_default_no','sms_default_period'], 'default' ,'value' => 0],

            [['profile', 'profile_en'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 21000 * 1024],
            [['icon'], 'file', 'skipOnEmpty' => true, 'extensions' => 'ico'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'slug' => Yii::t('app', 'Slug'),
            'slug_en' => Yii::t('app', 'Slug En'),
            'site_name' => Yii::t('app', 'Site Name'),
            'site_name_en' => Yii::t('app', 'Site Name En'),
            'description' => Yii::t('app', 'Description'),
            'description_en' => Yii::t('app', 'Description En'),
            'address' => Yii::t('app', 'Address'),
            'address_en' => Yii::t('app', 'Address En'),
            'mobile' => Yii::t('app', 'Mobile'),
            'phone' => Yii::t('app', 'Phone'),
            'email_admin' => Yii::t('app', 'Email Admin'),
            'email' => Yii::t('app', 'Email'),
            'facebook' => Yii::t('app', 'Facebook'),
            'twitter' => Yii::t('app', 'Twitter'),
            'youtube' => Yii::t('app', 'Youtube'),
            'linkedin' => Yii::t('app', 'Linkedin'),
            'instagram' => Yii::t('app', 'Instagram'),
            'lang' => Yii::t('app', 'Lang'),
            'lat' => Yii::t('app', 'Lat'),
            'profile' => Yii::t('app', 'Profile'),
            'profile_en' => Yii::t('app', 'Profile En'),
            'tax_number' => Yii::t('app', 'Tax Number'),
            'services_text' => Yii::t('app', 'Text In Services Page'),
            'services_text_en' => Yii::t('app', 'Text In Services Page En'),
            'partners_text' => Yii::t('app', 'Text In partners Page'),
            'partners_text_en' => Yii::t('app', 'Text In partners Page En'),
            'key_words' => Yii::t('app', 'Key Words'),
            'key_google_map' => Yii::t('app', 'Key Google Map'),
            'admin_theme' => Yii::t('app', 'Admin Theme'),
            'visit_number' => Yii::t('app', 'Visit Number'),
            'tax_percent_maintenance_order' => Yii::t('app', 'Tax Percent Maintenance Order'),
            'added_tax' => Yii::t('app', 'Added Tax'),
            'contract_default_type' => Yii::t('app', 'Default Contract Balance Type'),
            'contract_default_no' => Yii::t('app', 'Default Contract Balance'),
            'contract_default_period' => Yii::t('app', 'Default Contract Balance Period'),
            'sms_default_type' => Yii::t('app', 'Default Sms Balance Type'),
            'sms_default_no' => Yii::t('app', 'Default Sms Balance No'),
            'sms_default_period' => Yii::t('app', 'Default Sms Balance Period'),
            'contract_maintenance_free_no' => Yii::t('app', 'Contract Maintenance Free No'),
            'contract_maintenance_free_period' => Yii::t('app', 'Contract Maintenance Free Period'),
            'enable_installment_deposit_bank' => Yii::t('app', 'Enable Installment Deposit Bank'),
            'enable_installment_cash' => Yii::t('app', 'Enable Installment Cash'),
            'enable_installment_pay_card' => Yii::t('app', 'Enable Installment Pay Card'),
            'enable_installment_network' => Yii::t('app', 'Enable Installment Network'),
            'copyright' => Yii::t('app', 'Copyright'),
            'copyright_en' => Yii::t('app', 'Copyright En'),
            'about_image' => Yii::t('app', 'About Image'),
            'logo' => Yii::t('app', 'Logo'),
            'logo_footer' => Yii::t('app', 'Logo Footer'),
            'icon' => Yii::t('app', 'Icon'),
            'terms_and_conditions' => Yii::t('app', 'Terms And Conditions'),
            'terms_and_conditions_en' => Yii::t('app', 'Terms And Conditions En'),
            'default_nationality_id' => Yii::t('app', 'Default Nationalty when Signup'),
            'contact_email' => Yii::t('app', 'Contact Email'),
            'account_number' => Yii::t('app', 'Account Number'),
            'iban_number' => Yii::t('app', 'Iban Number'),
            'bank_name' => Yii::t('app', 'Bank Name'),
        ];
    }

    public function afterFind()
    {
        parent::afterFind();
        if (Yii::$app->language=='ar'){
            $this->_slug = $this->slug;
            $this->_site_name = $this->site_name ;
            $this->_address = $this->address ;
            $this->_description = $this->description ;
            $this->_services_text = $this->services_text ;
            $this->_partners_text = $this->partners_text ;
            $this->_terms_and_conditions = $this->terms_and_conditions ;
            $this->_copyright = $this->copyright ;
            
        }else{
            $this->_slug = $this->slug_en;
            $this->_site_name = $this->site_name_en;
            $this->_address = $this->address_en;
            $this->_description = $this->description_en;
            $this->_services_text = $this->services_text_en;
            $this->_partners_text = $this->partners_text_en;
            $this->_terms_and_conditions = $this->terms_and_conditions_en;
            $this->_copyright = $this->copyright_en;
        }
    }
}
