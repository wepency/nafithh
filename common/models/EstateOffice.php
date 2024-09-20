<?php

namespace common\models;

use common\components\GeneralHelpers;
use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "estate_office".
 *
 * @property int $id
 * @property string $name
 * @property string|null $logo
 * @property string $registration_code
 * @property string $auth_person
 * @property string $mobile
 * @property string|null $phone
 * @property string $email
 * @property string $registration_date
 * @property string|null $expire_date
 * @property int $status_account
 * @property int $sms_balance
 * @property string|null $sender_name
 * @property string|null $description
 * @property int $city_id
 * @property int $district_id
 * @property int $user_created_id
 * @property int $enable_installment_deposit_bank
 * @property int $enable_installment_cash
 * @property int $enable_installment_pay_card
 * @property int $enable_installment_network
 * @property int|null $contract_default_type 0 => 'Selected Balance',1 => 'Open Balance'
 * @property date|null $contract_expire_date
 * @property int|null $sms_default_type 0 => 'Selected Balance',1 => 'Open Balance'
 * @property date|null $sms_expire_date
 * @property int $admin_id
 * @property string $lang
 * @property string $lat
 * @property string|null $header_report_image
 * @property string|null $footer_report_image
 * @property string|null $notification_method //params ' ','sms','email','sms,email'
 * @property string|null $tax_num
 */
class EstateOffice extends \yii\db\ActiveRecord
{
    // const INSTALLMENT_DEPOSIT_BANK = 0;
    // const INSTALLMENT_CASH = 0;
    // const STATUS_PAY_CARD = 1;
    // const STATUS_NETWORK = 2;

    public $imageFiles;
    public $_username;
    public $_nationality_id;
    public $_password;
    public $asOwnerEstate;

    const NOTIF_TEMP_NEAR_EXPIR = 14;
    const EVENT_NEAR_EXPIR = 'eventExpir';

    public function init()
    {
        $this->on(self::EVENT_NEAR_EXPIR, [$this, self::EVENT_NEAR_EXPIR]);
        parent::init(); // DON'T Forget to call the parent method.
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estate_office';
    }

    public function behaviors()
    {
        return [
            'uploadBehavior' => [
                'class' => \common\behaviors\UploadBehavior::class,
                'fileAttribute' => 'logo',
                'saveDir' => Yii::getAlias("@upload/estate_office/")
            ],
            'uploadBehavior2' => [
                'class' => \common\behaviors\UploadBehavior::class,
                'fileAttribute' => 'header_report_image',
                'saveDir' => Yii::getAlias("@upload/estate_office/")
            ],
            'uploadBehavior3' => [
                'class' => \common\behaviors\UploadBehavior::class,
                'fileAttribute' => 'footer_report_image',
                'saveDir' => Yii::getAlias("@upload/estate_office/")
            ],
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
            [
                'class' => 'yii\behaviors\BlameableBehavior',
                'attributes' =>
                    [
                        \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => 'user_created_id',
                    ],
                'value' => function () {
                    return Yii::$app->user->identity->id ?? null;
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
            [['name', 'registration_code', 'auth_person', 'mobile', 'email', 'city_id', 'district_id', '_nationality_id'], 'required'],
            // [['_username', '_password'], 'required','on'=>'create'],
            ['_username', 'validateUsername', 'on' => 'create'],
            [['registration_date', 'expire_date', 'contract_expire_date', 'sms_expire_date'], 'safe'],
            [['status_account', 'sms_balance', 'contract_balance', 'city_id', 'district_id', 'user_created_id', 'enable_installment_deposit_bank', 'enable_installment_cash', 'enable_installment_pay_card', 'enable_installment_network', '_nationality_id', 'admin_id'], 'integer'],
            [['description'], 'string'],
            [['enable_installment_deposit_bank', 'enable_installment_cash', 'enable_installment_pay_card', 'enable_installment_network'], 'default', 'value' => 0],
            [['mobile'], 'match', 'pattern' => '/^(5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/', 'message' => yii::t('app', '5xxxxxxxx')],

            [['email'], 'email'],
            [['name', 'logo', 'auth_person', '_password', '_username'], 'string', 'max' => 150],
            [['registration_code', 'lang', 'lat'], 'string', 'max' => 70],
            [['mobile', 'phone', 'notification_method'], 'string', 'max' => 20],
            [['email', 'header_report_image', 'footer_report_image'], 'string', 'max' => 200],

            ['email', 'unique', 'on' => 'create', 'targetClass' => User::class, 'targetAttribute' => 'email', 'message' => yii::t('app', 'This email address has already been taken.'),],
            ['email', 'unique', 'message' => yii::t('app', 'This email address has already been taken.')],

            ['mobile', 'unique', 'on' => 'create', 'targetClass' => User::class, 'targetAttribute' => 'mobile', 'message' => yii::t('app', 'This mobile has already been taken.')],
            ['mobile', 'unique', 'message' => yii::t('app', 'This mobile has already been taken.')],

            ['registration_code', 'unique', 'on' => 'create', 'targetClass' => User::class, 'targetAttribute' => 'identity_id', 'message' => yii::t('app', 'This Identity Number has already been taken.')],
            ['registration_code', 'unique', 'message' => yii::t('app', 'This Registration Code has already been taken.')],


            [['tax_num'], 'string', 'max' => 50],
            [['sms_balance', 'contract_balance', 'asOwnerEstate'], 'default', 'value' => 0],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif, pdf, docx, xlsx', 'mimeTypes' => 'image/jpeg,image/jpg, image/png, image/gif,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'maxFiles' => 10],
        ];
    }

    public function validateUsername()
    {

        $user = User::findByUsername($this->_username);

        if (isset($user->id)) {
            $this->addError('_username', 'This username has already been taken.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'logo' => Yii::t('app', 'Logo'),
            'registration_code' => Yii::t('app', 'Registration Code'),
            'auth_person' => Yii::t('app', 'Auth Person'),
            'mobile' => Yii::t('app', 'Mobile'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'),
            'registration_date' => Yii::t('app', 'Registration Date'),
            'expire_date' => Yii::t('app', 'Expire Date'),
            'contract_expire_date' => Yii::t('app', 'Contract Expire Date'),
            'sms_expire_date' => Yii::t('app', 'Sms Expire Date'),
            'status_account' => Yii::t('app', 'Status Account'),
            'sms_balance' => Yii::t('app', 'Sms Balance'),
            'enable_installment_deposit_bank' => Yii::t('app', 'Enable Installment deposit bank'),
            'enable_installment_cash' => Yii::t('app', 'Enable Installment Cash'),
            'enable_installment_network' => Yii::t('app', 'Enable Installment Network'),
            'enable_installment_pay_card' => Yii::t('app', 'Enable Installment Pay Card'),
            'contract_balance' => Yii::t('app', 'Contract Balance'),
            'description' => Yii::t('app', 'Description'),
            'city_id' => Yii::t('app', 'City'),
            'district_id' => Yii::t('app', 'District'),
            'lang' => Yii::t('app', 'Lang'),
            'lat' => Yii::t('app', 'Lat'),
            'header_report_image' => Yii::t('app', 'Header Report Image'),
            'footer_report_image' => Yii::t('app', 'Footer Report Image'),
            'notification_method' => Yii::t('app', 'Notification Method'),
            'tax_num' => Yii::t('app', 'Tax Num'),
            '_nationality_id' => Yii::t('app', 'Nationality'),
            '_username' => Yii::t('app', 'Username'),
            '_password' => Yii::t('app', 'Password'),
            'contract_default_type' => Yii::t('app', 'Default Contract Balance Type'),
            'sms_default_type' => Yii::t('app', 'Default Sms Balance Type'),
            'asOwnerEstate' => Yii::t('app', 'As Owner Estate Office'),

        ];
    }


    public function beforeDelete()
    {
        if (parent::beforeDelete()) {

            $result =
                ($this->contracts) ? 'Contracts' : (
                (ContractFormEstateOffice::class::find()->where(['estate_office_id' => $this->id])->one()) ? 'Contract Forms' : (
                (OrderInfo::class::find()->where(['estate_office_id' => $this->id])->one()) ? 'Orders Info' : (
                (ReceiptVoucher::class::find()->where(['estate_office_id' => $this->id])->one()) ? 'Receipt Vouchers' : (
                (OrderInfo::class::find()->where(['sender_id' => $this->id, 'sender_type' => 'estate_officer'])->one()) ? 'Orders Info' :
                    null))));
            if ($result !== null) {
                Yii::$app->session->setFlash('force-delete',
                    yii::t('app', 'cannot delete {item} has items from {items}. {forceDelete}', [
                        'item' => yii::t('app', 'Estate Office'),
                        'items' => yii::t('app', $result),
                        'forceDelete' => Html::button('حذف نهائي', [
                            'class' => 'btn btn-flat btn-success force-delete',
                            'data-estate-id' => $this->id,
                        ])
                    ])
                );
                return false;
            }

            Yii::$app->session->setFlash('success', Yii::t('app', 'Deletes are done successfully.'));

            if ($this->admin && !\common\components\MultiUserType::deleteUserType($this->admin, 'estate_officer')) {
                return $this->terminateOfficeAccount();
            }
        }

        return false;

    }

    public function terminateOfficeAccount()
    {
        @User::deleteAll(['id' => $this->admin->id]);

        @EstateOfficeBuilding::deleteAll(['estate_office_id' => $this->id]);
        @UserEstateOffice::deleteAll(['estate_office_id' => $this->id]);
        @SettingEstateOffice::deleteAll(['estate_office_id' => $this->id]);
        @StatementReceiptCatch::deleteAll(['estate_office_id' => $this->id]);
        @Statement::deleteAll(['estate_office_id' => $this->id]);
        @Chat::deleteAll(['sender_id' => $this->id, 'sender_type' => 'estate_officer']);
        @Chat::deleteAll(['receiver_id' => $this->id, 'receiver_type' => 'estate_officer']);
        @BankAccountOffice::deleteAll(['estate_office_id' => $this->id]);
        @Attachment::deleteAll(['item_id' => $this->id, 'item_type' => $this->tableName()]);
        @GeneralHelpers::deleteImagesByPostId($this::class, $this->id);
        @EstateOffice::deleteAll(['id' => $this->id]);
        @Gallery::deleteAll(['user_id' => $this->admin_id]);

        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(District::class, ['id' => 'district_id']);
    }

    public function getBankAccountOffice()
    {
        return $this->hasMany(BankAccountOffice::class, ['estate_office_id' => 'id']);
    }

    /**
     *
     */
    public static function listOwner()
    {
        $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
        return $rows = (new \yii\db\Query())
            ->select(['user.id', 'user.name'])
            ->from('estate_office_owner')
            ->where(['estate_office_id' => $estate_office_id])
            ->rightJoin('user', 'user.id = estate_office_owner.owner_id')
            ->all();
    }

    public function getContracts()
    {
        return $this->hasMany(Contract::class, ['estate_office_id' => 'id']);
    }


    public function getEstateOfficeBuildings()
    {
        return $this->hasMany(EstateOfficeBuilding::class, ['estate_office_id' => 'id']);
    }

    public function getEstateOfficeOwners()
    {
        return $this->hasMany(EstateOfficeOwner::class, ['estate_office_id' => 'id']);
    }

    public function getEstateOfficeRenters()
    {
        return $this->hasMany(EstateOfficeRenter::class, ['estate_office_id' => 'id']);
    }


    // type [email or sms]
    public function checkAvalibalBalance($type = 'email')
    {
        if ($type === 'email' && !is_null($this->contract_expire_date)) {
            if (
                $this->contract_default_type === 1 ||
                ($this->contract_balance > 0 && strtotime($this->contract_expire_date) > time())
            )
                return true;
        } elseif ($type === 'sms' && !is_null($this->sms_expire_date)) {
            if (
                $this->sms_default_type === 1 ||
                ($this->sms_balance > 0 && strtotime($this->sms_expire_date) > time())
            )
                return true;
        }
        return false;
    }

    public function getAvailableBalance($type = 'email')
    {
        if ($type === 'email') {
            if (is_null($this->contract_expire_date))
                return 0;

            if (strtotime($this->contract_expire_date) < time()) {
                return 0;
            }

            return $this->contract_balance;
        } elseif ($type === 'sms') {
            return $this->sms_balance;
        }

        return false;
    }

    public static function getListPaymentMethod()
    {
        $listSetting = \common\components\GeneralHelpers::getAvailablePaymentMethod();
        return $listSetting;
    }

    public function getListAvailablePaymentMethod()
    {
        // in view used it
        // foreach ($estatOffice->getListAvailablePaymentMethod() as $key => $value) { 
        //             $list[$key] = Yii::$app->params['PayMethod'][Yii::$app->language][$key];
        //  }
        $list = [];
        $listSetting = \common\components\GeneralHelpers::getAvailablePaymentMethod();
        foreach ($listSetting as $key => $value) {
            if ($this->{$value} == 1) {
                $list[$key] = $value;
            }
        }
        return $list;
    }


    public function getAdmin()
    {
        return $this->hasOne(User::class, ['id' => 'admin_id']);
    }


    public function eventExpir($event)
    {
        $params = [
            're_id' => $this->id,
            're_type' => 'estate_officer',
            'content' => 'your Office is Remaining expire',
            'id' => $this->id,
            't_name' => 'setting-estate-office',
            'mobile' => $this->mobile,
            'email' => $this->email,

            'office_name' => $this->name,
            'expire_date' => $this->expire_date,
        ];

        \common\components\GeneralHelpers::sendNotif(self::NOTIF_TEMP_NEAR_EXPIR, $params, false);
    }


    public function getUserEstateOffice()
    {
        return $this->hasMany(UserEstateOffice::class, ['estate_office_id' => 'id']);
    }


    public static function deleteRelation($model, $item)
    {

        if (isset($item['items'])) {
            if ($model[$item['rel']]) {
                foreach ($model[$item['rel']] as $suIitem) {
                    foreach ($item['items'] as $suIitem2) {
                        self::deleteRelation($suIitem, $suIitem2);
                    }
                }
            }
        }
        if (is_array($model[$item['rel']])) {
            foreach ($model[$item['rel']] as $item) {
                $item->delete();
            }
        } else {
            $model[$item['rel']]->delete();
        }

        $model->delete();


    }

    public function deleteWithItems()
    {

        $tree = [
            [
                'rel' => 'contracts',
                'items' => [
                    [
                        'rel' => 'installments',
                        'items' => [
                            [
                                'rel' => 'installmentReceiptCatches',
                            ],
                        ],
                    ],
                ]
            ],
        ];

        foreach ($tree as $row) {
            self::deleteRelation($this, $row);
        }
        $orderinf = OrderInfo::find()->where(['or', ['estate_office_id' => $this->id], ['sender_id' => $this->id, 'sender_type' => 'estate_officer']])->all();

        foreach ($orderinf as $row) {
            self::deleteRelation($row, ['rel' => 'orderMaintenances']);
        }
        self::deleteAllRecord(ContractFormEstateOffice::class, ['estate_office_id' => $this->id]);
        self::deleteAllRecord(ReceiptVoucher::class, ['estate_office_id' => $this->id]);

        $this->delete();
    }


    public static function deleteAllRecord($class, $condition)
    {
        $flag = true;
        $models = $class::find()->where($condition)->all();
        foreach ($models as $row => $value) {
            $flag = $value->delete();

            if ($flag === false) {
                break;
            }
        }
        return $flag;

    }


}
