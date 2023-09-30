<?php

namespace common\models;

//use yii\validators\Validator;
use common\components\GeneralHelpers;
use Yii;
use yii\helpers\Html;


//use yii\base\Model;

/**
 * This is the model class for table "building".
 *
 * @property int $id
 * @property int $owner_id
 * @property string $instrument_number
 * @property string $building_name
 * @property int $building_type_id
 * @property int $floors
 * @property int $housing_units
 * @property int $city_id
 * @property int $district_id
 * @property string $lang
 * @property string $lat
 * @property string $building_status params (new=>new,old=>old)
 * @property string $building_age
 * @property string $description
 * @property string $annual_income
 * @property string $width
 * @property string $length
 * @property string $water_meter_no
 * @property string $east //disabled 
 * @property string $west //disabled 
 * @property string $north //disabled 
 * @property string $south //disabled 
 * @property int $status //disabled and used ad_status
 * @property int $housing_units_available read only
 * @property int $housing_units_rented read only
 * @property int|null $has_parking
 * @property int $for_rent
 * @property int $for_sale
 * @property int $for_invest
 * @property float $rent_price
 * @property float $invest_price
 * @property float $sale_price
 * @property string $updated_at
 */
class Building extends \yii\db\ActiveRecord

{
	public $receive_date;
	public $expire_date;
	public $imageFiles;
	public $type;

	const NOTIF_TEMP_VIEW_RENTER_PAY_ESTATE = 10;
	const NOTIF_TEMP_VIEW_RENTER_PAY_OWNERS = 11;
	const EVENT_VIEW_RENTER_PAY = 'eventViewRenterAndPay';

	const NOTIF_TEMP_NEW = 12;
	const EVENT_NEW = 'eventNew';

	public function init()
	{
		$this->on(self::EVENT_VIEW_RENTER_PAY, [$this, self::EVENT_VIEW_RENTER_PAY]);
		$this->on(self::EVENT_NEW, [$this, self::EVENT_NEW]);
		parent::init(); // DON'T Forget to call the parent method.
	}
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'building';
	}

	public static function find()
	{
		return new \common\query\GlobalQuery(get_called_class());
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

		];
	}
	/**
	 * {@inheritdoc}
	 */

	// public function rulesback()
	// {
	// 	return [
	// 		//[['owner_id'], 'required'],
	// 		[['owner_id', 'instrument_number', 'building_name', 'building_type_id', 'floors', 'housing_units', 'city_id', 'district_id' /*, 'lang', 'lat'*/, 'building_age', 'status', 'east', 'west', 'north', 'south'], 'required'],
	// 		// [['receive_date', 'expire_date'], 'required','on'=>'create'],

	// 		//[['owner_id'], 'integer'],
	// 		[['owner_id', 'building_type_id', 'floors', 'housing_units', 'city_id', 'district_id', 'status', /*'housing_units_available', 'housing_units_rented',*/ 'has_parking'], 'integer'],
	// 		[['description'], 'string'],
	// 		[['housing_units_available', 'housing_units_rented', 'rent_price', 'sale_price', 'space', 'number_of_rooms', /*'limits_length_property',*/ 'space', 'no_elevators', 'number_parking', 'east', 'west', 'north', 'south'], 'default', 'value' => 0],
	// 		[['rent_price', 'sale_price'], 'number'],
	// 		[['updated_at', 'housing_units_available', 'housing_units_rented', 'receive_date', 'expire_date', 'ad_publish_date', 'ad_expire_date'], 'safe'],
	// 		[['instrument_number', 'building_age'], 'string', 'max' => 100],
	// 		['instrument_number', 'unique', 'message' => yii::t('app', 'This instrument number has already been taken.')],
	// 		[['building_name'], 'string', 'max' => 255],
	// 		[['annual_income'], 'string', 'max' => 250],
	// 		[['lang', 'lat', 'water_meter_no'], 'string', 'max' => 50],
	// 		[['building_status'], 'string', 'max' => 30],
	// 		[['building_status'], 'default', 'value' => 'new'],
	// 		[['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif, pdf, docx, xlsx', 'mimeTypes' => 'image/jpeg,image/jpg, image/png, image/gif,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'maxFiles' => 10],

	// 	];
	// }

	public function validateCountry($attribute, $params, $validator)
	{
		if (!in_array($this->$attribute, ['USA', 'Indonesia'])) {
			$this->addError($attribute, 'The country must be either "USA" or "Indonesia".');
		}
	}

	public function checkLicense($attribute, $params)
	{
		if ($params['strength'] === self::WEAK) {
			$pattern = '/^(?=.*[a-zA-Z0-9]).{5,}$/';
		} else {
			$pattern = '/^(?=.*\d(?=.*\d))(?=.*[a-zA-Z](?=.*[a-zA-Z])).{5,}$/';
		}

		if ($this->$attribute == '') {
			$this->addError($attribute, 'Cant empty');
		}

		if (!preg_match($pattern, $this->$attribute)) {
			$this->addError($attribute, 'your password is not strong enough!');
		}
	}

	public function checkDateFormat($attribute, $params)
	{
		// no real check at the moment to be sure that the error is triggered
		$this->addError($attribute, Yii::t('user', 'You entered an invalid date format.'));
	}

	public function validateAdvertiserLicenceNumber($attribute, $params)
	{

		//$url = 'https://intgtest.rega.gov.sa:233/api/v1/DelegatedAd/Authorize';
		//$client_id = '5b284a15';
		//$secret = 'ab8ca37e-3d33-426e-a437-f36b59a48d67';

		$url = 'https://apigateway.rega.gov.sa/api/v1/DelegatedAd/Authorize';
		$client_id = 'fc908874';
		$secret = '4f0f1c28-d5ae-48fb-9a1a-60ac4b2cf7f3';

		$headers = array('Content-Type: application/json');

		$fields = array(
			"client_id" => "$client_id",
			"client_secret" => "$secret",
		);
		// Send request to Server
		$ch = curl_init($url);

		
		// To save response in a variable from server, set headers;
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		// Get response
		$response = curl_exec($ch);
		// Decode
		$results = json_decode($response);
		// echo "<pre>";
		// print_r($_SERVER);
		// die();
		if (!$results || (isset($_SERVER['SERVER_NAME'],$_SERVER['HTTP_HOST']) && $_SERVER['SERVER_NAME']=='localhost') ) {
			return;
		}
		curl_close($ch);

		$access_token = $results->access_token;

		$ch1 = curl_init();
		//$url = "https://api.mywebtuts.com/api/users";
		//$dataArray = ['page' => 2];

		$url = 'https://apigateway.rega.gov.sa/api/v1/DelegatedAd/isValidAd';
		//$dataArray = array('Type_Id' => '1', 'Id_Number' => '1015872025', 'Ad_Number' => '012694');

		$dataArray = array('Type_Id' => '1', 'Id_Number' => $this->advertiser_license_number, 'Ad_Number' => $this->authorization_number);
		//$dataArray = array('Type_Id' => '1', 'Id_Number' => $this->advertiser_license_number, 'Ad_Number' => $this->instrument_number);
		// $dataArray = array('Type_Id' => '1', 'Id_Number' => '1234567890', 'Ad_Number' => 'A2423423');

		$data = http_build_query($dataArray);

		$getUrl = $url . "?" . $data;

		$headers = array(
			"Accept: application/json",
			"Authorization: Bearer " . $access_token,
		);

		curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch1, CURLOPT_URL, $getUrl);
		curl_setopt($ch1, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch1);
		$is_error = curl_error($ch1);
		// echo '<br>';
		$httpcode = curl_getinfo($ch1, CURLINFO_HTTP_CODE);

		$website_language = Yii::$app->language;
		$error_key = 'errorMsg_AR';

		if (!empty($website_language)) {
			$error_key = 'errorMsg_' . strtoupper($website_language);
		}
		curl_close($ch1);
		$response = json_decode($response, true);

		if (is_array($response)) {
			if (isset($response['errorMsg_EN'])) {
				$error = $response[$error_key];
				if ($response['errorMsg_EN'] == 'Invalid ID Number') {
					$this->addError('authorization_number', $error);
				} else {
					$this->addError('advertiser_license_number', $error);
				}
			}
		}
	}

	public function rules()
	{
		return [


			[['advertiser_license_number', 'owner_id', 'building_name', 'building_type_id', 'floors', 'housing_units', 'city_id', 'district_id' /*, 'lang', 'lat', 'building_age'*/, 'neighborhood_name', 'advertiser_name', 'advertiser_mobile', 'limit_property', 'document_rights', 'information_affects', 'ad_description', 'ad_publish_date', 'ad_expire_date', 'advertiser_side', 'advertiser_adjective', 'advertiser_email', 'ad_type', 'ad_subtype', 'ad_status', 'street_name', 'real_estate_interface', 'room_type', 'using_for','width','length', 'street_view','agreeterms','authorization_number', 'space'], 'required'],


            //[['advertiser_license_number', 'owner_id', 'instrument_number', 'building_name', 'building_type_id', 'floors', 'housing_units', 'city_id', 'district_id' /*, 'lang', 'lat'*/, 'building_age', 'neighborhood_name', 'advertiser_name', 'advertiser_mobile',  'ad_description', 'ad_publish_date', 'ad_expire_date', 'advertiser_side', 'advertiser_adjective', 'advertiser_email', 'ad_type', 'ad_subtype', 'ad_status', 'real_estate_interface', 'room_type', 'using_for',   'agreeterms'], 'required'],

			['advertiser_license_number', 'validateAdvertiserLicenceNumber', 'skipOnEmpty' => false, 'skipOnError' => false],

			// ['authorization_number', 'required', 'when' => function ($model) {
			// 	return $model->advertiser_adjective == '1';
			// }, 'whenClient' => "function (attribute, value) {

   //              return $('#building-advertiser_adjective input[type=\'radio\']:checked').val() == '0';
   //          }",],

			[['rent_price'], 'required', 'when' => function($model) {
                return $model->for_rent == 1 ;
            }, 'whenClient' => "function (attribute, value) {
                id = '".Html::getInputId($this,'for_rent')."';
                return $('#'+id)[0].checked == true ;
            }"],

            [['sale_price'], 'required', 'when' => function($model) {
                return $model->for_sale == 1 ;
            }, 'whenClient' => "function (attribute, value) {
                id = '".Html::getInputId($this,'for_sale')."';
                return $('#'+id)[0].checked == true ;
            }"],

            [['invest_price'], 'required', 'when' => function($model) {
                return $model->for_invest == 1 ;
            }, 'whenClient' => "function (attribute, value) {
                id = '".Html::getInputId($this,'for_invest')."';
                return $('#'+id)[0].checked == true ;
            }"],

			['limit_property_yes', 'required', 'when' => function ($model) {
				return $model->limit_property == '1';
			}, 'whenClient' => "function (attribute, value) {

                return $('#building-limit_property input[type=\'radio\']:checked').val() == '1';
            }",],

			['document_rights_yes', 'required', 'when' => function ($model) {
				return $model->document_rights == '1';
			}, 'whenClient' => "function (attribute, value) {

                return $('#building-document_rights input[type=\'radio\']:checked').val() == '1';
            }",],

			['information_affects_yes', 'required', 'when' => function ($model) {
				return $model->information_affects == '1';
			}, 'whenClient' => "function (attribute, value) {

                return $('#building-information_affects input[type=\'radio\']:checked').val() == '1';
            }",],

			[['owner_id', 'building_type_id', 'floors', 'housing_units', 'city_id', 'district_id', 'status', 'housing_units_available', 'housing_units_rented' ,'for_rent','for_sale','for_invest'], 'integer'],
			[['description'], 'string'],
			[['housing_units_available', 'housing_units_rented', 'rent_price','sale_price','invest_price', 'space', 'number_of_rooms', 'limit_property', 'document_rights', 'information_affects', 'has_parking', 'furnished', 'kitchen', 'aircondition', 'ad_subtype', 'ad_status', 'availability_elevators', 'availability_parking', 'space', 'number_of_rooms', 'limits_length_property', 'no_elevators', 'number_parking', 'using_for','width','length','for_rent','for_sale','for_invest'], 'default', 'value' => 0],
			//[['rent_price', 'sale_price' ], 'number'],
			[['building_age'], 'number','max'=>127],
			[['status', 'building_age'], 'default', 'value' => 0],
			[['ad_type'], 'default', 'value' => 1],

			[['ad_publish_date', 'ad_expire_date'], 'default', 'value' => '0000-00-00'],
			[['updated_at', 'housing_units_available', 'housing_units_rented', 'receive_date', 'expire_date'], 'safe'],
			[['instrument_number', 'neighborhood_name', 'room_type', 'real_estate_interface', 'advertiser_side', 'advertiser_adjective', 'advertiser_license_number', 'advertiser_email', 'advertiser_registration_number', 'authorization_number', 'limit_property_yes', 'document_rights_yes', 'information_affects_yes'], 'string', 'max' => 100],
			// ['instrument_number', 'unique', 'message' => yii::t('app', 'This instrument number has already been taken.')],
			[['building_name'], 'string', 'max' => 255],
			[['annual_income'], 'string', 'max' => 250],
			[['ad_description'], 'string', 'max' => 1000],
			[['lang', 'lat', 'water_meter_no', 'street_name', 'longitude', 'lattitude', 'street_view', 'facilities'], 'string', 'max' => 50],
			[['building_status'], 'string', 'max' => 30],
			[['building_status'], 'default', 'value' => 'new'],
			[['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif, pdf, docx, xlsx', 'mimeTypes' => 'image/jpeg,image/jpg, image/png, image/gif,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'maxFiles' => 10],

		];
	}

	public function specialRules()
	{
		if (\Input::get('advertiser_adjective') == 1) {
			$this->rules['authorization_number'] = 'required';
		}

		return $this;
	}

	// public function rulestest()
	// {
	// 	return [
	// 		//[['owner_id', 'instrument_number', 'building_name', 'building_type_id', 'floors', 'housing_units', 'city_id', 'district_id'/*, 'lang', 'lat'*/, 'building_age', 'status', 'neighborhood_name', 'advertiser_name', 'advertiser_mobile'], 'required'],
	// 		[['owner_id', 'instrument_number', 'building_name', 'building_type_id', 'floors', 'housing_units', 'city_id', 'district_id' /*, 'lang', 'lat'*/, 'building_age', 'status', 'neighborhood_name', 'advertiser_name', 'advertiser_mobile'], 'required'],

	// 		// [['receive_date', 'expire_date'], 'required','on'=>'create'],

	// 		[['owner_id', 'building_type_id', 'floors', 'housing_units', 'city_id', 'district_id', 'status', 'housing_units_available', 'housing_units_rented', 'has_parking', 'availability_elevators', 'availability_parking', 'limit_property', 'document_rights', 'information_affects', 'furnished', 'kitchen', 'aircondition', 'ad_type', 'ad_subtype', 'ad_status'], 'integer'],
	// 		[['description'], 'string'],
	// 		[['housing_units_available', 'housing_units_rented', 'rent_price', 'sale_price'], 'default', 'value' => 0],
	// 		[['rent_price', 'sale_price', 'space', 'number_of_rooms', 'limits_length_property', 'space', 'no_elevators', 'number_parking'], 'number'],
	// 		[['updated_at', 'housing_units_available', 'housing_units_rented', 'receive_date', 'expire_date', 'ad_publish_date', 'ad_expire_date'], 'safe'],
	// 		[['instrument_number', 'building_age', 'neighborhood_name', 'room_type', 'real_estate_interface', 'advertiser_side', 'advertiser_adjective', 'advertiser_license_number', 'advertiser_email', 'advertiser_registration_number', 'authorization_number'], 'string', 'max' => 100],
	// 		['instrument_number', 'unique', 'message' => yii::t('app', 'This instrument number has already been taken.')],
	// 		[['building_name'], 'string', 'max' => 255],
	// 		[['annual_income'], 'string', 'max' => 250],
	// 		[['ad_description'], 'string', 'max' => 1000],
	// 		[['lang', 'lat', 'water_meter_no', 'street_name', 'longitude', 'lattitude', 'street_view', 'facilities'], 'string', 'max' => 50],
	// 		[['building_status'], 'string', 'max' => 30],
	// 		[['building_status'], 'default', 'value' => 'new'],
	// 		[['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif, pdf, docx, xlsx', 'mimeTypes' => 'image/jpeg,image/jpg, image/png, image/gif,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'maxFiles' => 10],

	// 	];
	// }

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => Yii::t('app', 'ID'),
			'owner_id' => Yii::t('app', 'Owner'),
			'instrument_number' => Yii::t('app', 'Instrument Number'),
			'building_name' => Yii::t('app', 'Building Name'),
			'building_type_id' => Yii::t('app', 'Building Type'),
			'floors' => Yii::t('app', 'Floors'),
			'housing_units' => Yii::t('app', 'Housing Units'),
			'city_id' => Yii::t('app', 'City'),
			'district_id' => Yii::t('app', 'District'),
			'lang' => Yii::t('app', 'Lang'),
			'lat' => Yii::t('app', 'Lat'),
			'building_status' => Yii::t('app', 'Building Status'),
			'building_age' => Yii::t('app', 'Building Age'),
			'description' => Yii::t('app', 'Estate Details'),
			'status' => Yii::t('app', 'Status'),
			'housing_units_available' => Yii::t('app', 'Housing Units Available'),
			'housing_units_rented' => Yii::t('app', 'Housing Units Rented'),
			'has_parking' => Yii::t('app', 'Has Parking'),
			'for_rent' => Yii::t('app', 'For Rent'),
			'for_invest' => Yii::t('app', 'For Invest'),
			'for_sale' => Yii::t('app', 'For Sale'),
			'rent_price' => Yii::t('app', 'Rent Price'),
			'sale_price' => Yii::t('app', 'Sale Price'),
			'invest_price' => Yii::t('app', 'Invest Price'),
			'updated_at' => Yii::t('app', 'Updated At'),
			'receive_date' => Yii::t('app', 'Receive Date'),
			'expire_date' => Yii::t('app', 'Expire Date'),
			'annual_income' => Yii::t('app', 'annual income'),
			'water_meter_no' => Yii::t('app', 'Water Meter Number'),
			'neighborhood_name' => Yii::t('app', 'Neighborhood Name'),
			'space' => Yii::t('app', 'Space'),
			'number_of_rooms' => Yii::t('app', 'Number of Rooms'),
			'street_name' => Yii::t('app', 'Street Name'),
			'longitude' => Yii::t('app', 'Longitude'),
			'lattitude' => Yii::t('app', 'Lattitude'),
			'room_type' => Yii::t('app', 'Room Type'),
			'real_estate_interface' => Yii::t('app', 'Real Estate Interface'),
			'street_view' => Yii::t('app', 'Street Width'),
			'limits_length_property' => Yii::t('app', 'Limits and Lengths of the Property'),
			'furnished' => Yii::t('app', 'Furnished'),
			'kitchen' => Yii::t('app', 'Kitchen'),
			'aircondition' => Yii::t('app', 'Air Condition'),
			'facilities' => Yii::t('app', 'Facilities'),
			'availability_elevators' => Yii::t('app', 'Availability of Elevators'),
			'no_elevators' => Yii::t('app', 'Number of Elevators'),
			'availability_parking' => Yii::t('app', 'Availability of Parking'),
			'number_parking' => Yii::t('app', 'Number of Parking'),
			'limit_property' => Yii::t('app', 'Is there a mortgage or restriction that prevents or limits the disposal or use of the property?'),
			'document_rights' => Yii::t('app', 'Rights and obligations over real estate not documented in the real estate document'),
			'information_affects' => Yii::t('app', 'Information that may affect the property'),
			'width' => Yii::t('app', 'Width'),
			'limit_property_yes' => Yii::t('app', 'Limit Property'),
			'document_rights_yes' => Yii::t('app', 'Document Rights'),
			'information_affects_yes' => Yii::t('app', 'Information Affects'),
			'length' => Yii::t('app', 'Length'),
			'ad_description' => Yii::t('app', 'Title Ads'),
			'ad_publish_date' => Yii::t('app', 'Publication Date'),
			'ad_expire_date' => Yii::t('app', 'Expiration Date'),
			'advertiser_side' => Yii::t('app', 'Advertiser Category'),
			'advertiser_adjective' => Yii::t('app', 'Advertiser Character'),
			'advertiser_license_number' => Yii::t('app', 'Advertiser License Number'),
			'advertiser_name' => Yii::t('app', 'Advertiser Name'),
			'advertiser_email' => Yii::t('app', "Advertiser's Email"),
			'advertiser_mobile' => Yii::t('app', 'Advertiser Mobile Number'),
			'advertiser_registration_number' => Yii::t('app', 'Advertiser Registration Number'),
			'authorization_number' => Yii::t('app', 'Authorization Number'),
			'ad_type' => Yii::t('app', 'Ad Type'),
			'ad_subtype' => Yii::t('app', 'Ad Sub Type'),
			'ad_status' => Yii::t('app', 'Status Ad'),
		];
	}


	public function date()
    {
        // $date = \common\components\GeneralHelpers::formatDate($this->ad_publish_date)[0];
        $date = '';
        $date .= ' '. \common\components\GeneralHelpers::formatDate($this->ad_publish_date)[0];
        return $date;
    }

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getEstateContract()
	{
		return $this->hasOne(EstateOfficeBuilding::class, ['building_id' => 'id'])->where(['is_active' => 1]);
	}

	public function getContracts()
	{
		return $this->hasMany(Contract::class, ['building_id' => 'id']);
	}

	public function beforeDelete()
	{
		if (parent::beforeDelete()) {
			$result =
				($this->buildingHousingUnits) ? 'Building Housing Units' : (
					($this->contracts) ? 'Contracts' :
					null);
			if ($result !== null) {
				Yii::$app->session->setFlash(
					'danger',
					yii::t('app', 'cannot delete {item} has items from {items}.', [
						'item' => yii::t('app', 'Building'), 'items' => yii::t('app', $result),
					])
				);
				return false;
			}

			Yii::$app->session->setFlash('success', Yii::t('app', 'Deletes are done successfully.'));

			EstateOfficeBuilding::deleteAll(['building_id' => $this->id]);
			Attachment::deleteAll(['item_id' => $this->id, 'item_type' => $this->tableName()]);
			GeneralHelpers::deleteImagesByPostId($this::class, $this->id);
			return true;
		}
		return false;
	}

	public function getCity()
	{
		return $this->hasOne(City::class, ['id' => 'city_id']);
	}

	public function getDistrict()
	{
		return $this->hasOne(District::class, ['id' => 'district_id']);
	}

	public function getOwner()
	{
		return $this->hasOne(User::class, ['id' => 'owner_id']);
	}

	public function getBuildingType()
	{
		return $this->hasOne(BuildingType::class, ['id' => 'building_type_id']);
	}

	public function getEstateOfficeBuildings()
	{
		return $this->hasMany(EstateOfficeBuilding::class, ['building_id' => 'id']);
	}

	public function getBuildingHousingUnits()
	{
		return $this->hasMany(BuildingHousingUnit::class, ['building_id' => 'id']);
	}

	public function getBuildingHousingUnitsAvailable()
	{
		return $this->hasMany(BuildingHousingUnit::class, ['building_id' => 'id'])->rented(false);
	}

	public function getBuildingHousingUnitsRented()
	{
		return $this->hasMany(BuildingHousingUnit::class, ['building_id' => 'id'])->rented();
	}

	public static function ListBuildingByOwner($owner_id = 0)
	{
		if ($owner_id != 0) {
			$estate_office_id = GeneralHelpers::getEstateOfficeId();
			$droptions = (new \yii\db\Query())
				->select(['building.building_name', 'building.id'])
				->from('estate_office_building')
				->where(['estate_office_building.estate_office_id' => $estate_office_id, 'is_active' => 1, 'estate_office_building.owner_id' => $owner_id])
				->leftJoin('building', 'building.id = estate_office_building.building_id')
				->all();
		} else {
			$droptions = array();
		}

		return \yii\helpers\Arrayhelper::map($droptions, 'id', 'building_name');
	}

	public function eventViewRenterAndPay($event, $isNew = false)
	{

		if ($this->ad_status == 1) {
			$attributes = ['for_rent', 'for_sale','for_invest'];
			foreach ($attributes as $row) {
				if ($this->$row == 1 && ($isNew || $this->getOldAttribute($row) != $this->$row)) {
					$status = $this->attributeLabels()[$row];

					if($row == 'for_invest')
						$ad_subtype = 0;
					elseif ($row == 'for_rent')
						$ad_subtype = 2;
					else 
						$ad_subtype = 1;

			        $link =Yii::$app->BaseUrl->baseUrl. '/gallery/' . $this->id.'?type='.$ad_subtype;
				    // $link = Html::a(yii::t('app','Click me'), $link,['target'=>'_blank']);

					$params = [
						're_id' => $this->estateContract->estate_office_id,
						're_type' => 'estate_officer',
						'content' => 'Building view for renter Or pay',
						'id' => $this->id,
						't_name' => 'building',
						'mobile' => $this->estateContract->estateOffice->mobile,
						'email' => $this->estateContract->estateOffice->email,

						'building_name' => $this->building_name,
						'estate_office_name' => $this->estateContract->estateOffice->name,
						'owner_name' => $this->owner->name,
						'status_view' => $status,
					];
					\common\components\GeneralHelpers::sendNotif(self::NOTIF_TEMP_VIEW_RENTER_PAY_ESTATE, $params, $this->estateContract->estateOffice->id);

					$params = [
						're_id' => $this->owner->id,
						're_type' => 'owner',
						'content' => 'Building view for renter Or pay',
						'id' => $this->id,
						't_name' => 'building',
						'mobile' => $this->owner->mobile,
						'email' => $this->owner->email,

						'building_name' => $this->building_name,
						'estate_office_name' => $this->estateContract->estateOffice->name,
						'owner_name' => $this->owner->name,
						'status_view' => $status,
						'url' => $link,
					];

					\common\components\GeneralHelpers::sendNotif(self::NOTIF_TEMP_VIEW_RENTER_PAY_OWNERS, $params, $this->estateContract->estateOffice->id);
				};
			};
		}
	}

	public function eventNew($event)
	{
		$this->eventViewRenterAndPay(null, true);
		$params = [
			're_id' => $this->owner->id,
			're_type' => 'owner',
			'content' => 'Building added success',
			'id' => $this->id,
			't_name' => 'building',
			'mobile' => $this->owner->mobile,
			'email' => $this->owner->email,

			'building_name' => $this->building_name,
			'estate_office_name' => $this->estateContract->estateOffice->name,
		];

		\common\components\GeneralHelpers::sendNotif(self::NOTIF_TEMP_NEW, $params, $this->estateContract->estateOffice->id);
	}
}
