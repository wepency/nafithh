<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\BaseActiveRecord;
use yii\db\Expression;
use Yii;

class Gallery extends \yii\db\ActiveRecord
{

    public $_id;
    public $_user_id;

    public $_name;
    public $_description;
    public $_advertiserId;
    public $_adLicenseId;
    public $_adLicenseNumber;
    public $_advertiserName;
    public $imageFiles;
    public $_isConstrained;
    public $_isPawned;

    public $_city;
    public $_street;

    public $_district;

    public $_region;

    public $_buildingNumber;
    public $_address;
    public $_lng;
    public $_lat;
    public $_streetWidth;
    public $_propertyArea;
    public $_propertyPrice;
    public $_numberOfRooms;
    public $_propertyType;
    public $_propertyAge;
    public $_advertisementType;
    public $_obligations;
    public $_guarantees;
    public $_borders;
    public $_compliance;
    public $_channels;
    public $_propertyUsages;
    public $_propertyUtilities;
    public $_creationDate;
    public $_endDate;
    public $_qrCodeUrl;
    public $_status;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gallery';
    }

    public function rules()
    {
        return [
            [['adLicenseNumber', 'adLicenseId', 'propertyPrice', 'name', 'description', 'address', 'lat', 'lng'], 'required'],
            [['adLicenseNumber'], 'unique', 'skipOnEmpty' => false, 'on' => 'insert'],
            [['imageFiles'], 'file', 'extensions' => 'png, jpg, jpeg, gif', 'maxFiles' => 10]
        ];
    }

    // Define the relationship
    public function getUser()
    {
        // Define the relationship between Gallery and User
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function behaviors()
    {
        return [
            'uploadBehavior' => [
                'class' => \common\behaviors\UploadBehavior::class,
                'fileAttribute' => 'image',
                'saveDir' => \Yii::getAlias("@upload/attachment/")
            ],

            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                'value' => new Expression('NOW()'),
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
        ];
    }

    public function search($params, $query = null)
    {

        if (is_null($query)){
            $query = Gallery::find();
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
//        $query->andFilterWhere([
//            'id' => $this->id,
//            'page_name' => $this->page_name,
//            'status' => $this->status,
//        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'advertiserId' => Yii::t('app', 'Advertiser ID'),
            'adLicenseId' => Yii::t('app', 'Ad License ID'),
            'adLicenseNumber' => Yii::t('app', 'Ad License Number'),
            'advertiserName' => Yii::t('app', 'Advertiser Name'),
            'imageFiles' => Yii::t('app', 'Image Files'),
            'isConstrained' => Yii::t('app', 'Is Constrained'),
            'isPawned' => Yii::t('app', 'Is Pawned'),
            'city' => Yii::t('app', 'City'),
            'street' => Yii::t('app', 'Street'),
            'district' => Yii::t('app', 'District'),
            'region' => Yii::t('app', 'Region'),
            'buildingNumber' => Yii::t('app', 'Building Number'),
            'address' => Yii::t('app', 'Address'),
            'lng' => Yii::t('app', 'Longitude'),
            'lat' => Yii::t('app', 'Latitude'),
            'streetWidth' => Yii::t('app', 'Street Width'),
            'propertyArea' => Yii::t('app', 'Property Area'),
            'propertyPrice' => Yii::t('app', 'Property Price'),
            'numberOfRooms' => Yii::t('app', 'Number of Rooms'),
            'propertyType' => Yii::t('app', 'Property Type'),
            'propertyAge' => Yii::t('app', 'Property Age'),
            'advertisementType' => Yii::t('app', 'Advertisement Type'),
            'obligations' => Yii::t('app', 'Obligations'),
            'guarantees' => Yii::t('app', 'Guarantees'),
            'borders' => Yii::t('app', 'Borders'),
            'compliance' => Yii::t('app', 'Compliance'),
            'channels' => Yii::t('app', 'Channels'),
            'propertyUsages' => Yii::t('app', 'Property Usages'),
            'propertyUtilities' => Yii::t('app', 'Property Utilities'),
            'creationDate' => Yii::t('app', 'Creation Date'),
            'endDate' => Yii::t('app', 'End Date'),
            'qrCodeUrl' => Yii::t('app', 'QR Code URL'),
        ];
    }
}