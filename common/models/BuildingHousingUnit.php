<?php

namespace common\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "building_housing_unit".
 *
 * @property int $id
 * @property int $building_id
 * @property string $housing_unit_name
 * @property int $floors_no
 * @property int $building_type_id
 * @property float $rent_price
 * @property string|null $area
 * @property int $rooms
 * @property int $entrances
 * @property int $has_parking
 * @property int $toilets
 * @property string $width
 * @property string $length
 * @property int $kitchen (yes,no)
 * @property string|null $furniture
 * @property int $conditioner_num
 * @property int $pool (yes,no)
 * @property int $lounge 
 * @property string|null $detail
 * @property string|null $electricity_meter_no
 * @property int $using_for  params 1 => 'Rented',0 => 'Not Renter'
 * @property int $status 1 => 'Rented',0 => 'Not Renter'
 * @property int $for_rent
 * @property int $for_sale
 * @property float $invest_price
 * @property float $sale_price
 */
class BuildingHousingUnit extends \yii\db\ActiveRecord
{

	const EVENT_VIEW_RENTER_PAY = 'eventViewRenterAndPay';
	const EVENT_NEW = 'EventNew';
	public $imageFiles;

	public function init(){
		$this->on(self::EVENT_VIEW_RENTER_PAY, [$this, self::EVENT_VIEW_RENTER_PAY]);
		$this->on(self::EVENT_NEW, [$this, self::EVENT_NEW]);
		parent::init(); // DON'T Forget to call the parent method.
	}
		/**
		 * {@inheritdoc}
		 */
		public static function tableName()
		{
			return 'building_housing_unit';
		}

		public static function find()
		{
			return new \common\query\BuildingHousingUnitQuery(get_called_class());
		}
		/**
		 * {@inheritdoc}
		 */
  		

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
        
  
        public function rules()
		{
			return [
				//[['housing_unit_name', 'building_type_id', 'rent_price','using_for','floors_no', 'kitchen','pool', 'neighborhood_name', 'advertiser_name', 'advertiser_mobile'], 'required'],
//                [['housing_unit_name', 'building_type_id', /*'rent_price',*/ 'using_for','floors_no', 'kitchen','pool', 'space', 'rooms'/*,'width','length',*/ ,'room_type', 'ad_subtype','ad_publish_date', 'ad_expire_date','ad_status'], 'required'],
                [['housing_unit_name', /*'room_type' 'rent_price', 'using_for', 'kitchen','pool','rooms','width','length', 'ad_subtype','ad_publish_date', 'ad_expire_date','ad_status'*/], 'required'],
				[['building_id'], 'required','on'=>'create'],

				//[['building_id', 'floors_no', 'building_type_id', 'rooms', 'entrances', 'has_parking', 'toilets', 'kitchen', 'conditioner_num', 'pool', 'using_for', 'status','lounge', 'space', 'number_of_rooms', 'limit_property', 'document_rights', 'ad_type', 'ad_subtype'], 'integer'],
                [['building_id', 'floors_no', 'building_type_id', 'rooms', 'entrances', 'has_parking', 'toilets', 'kitchen', 'conditioner_num', 'pool', 'using_for', 'status' ,'lounge','ad_status','for_rent','for_sale','for_invest'], 'integer'],
				[['rent_price', 'sale_price','invest_price'], 'number'],
				
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

				[['rent_price', 'sale_price','invest_price','for_rent','for_sale','for_invest'], 'default', 'value' => 0],
               // [['ad_publish_date', 'ad_expire_date'], 'safe'],
				[['housing_unit_name','room_type','width','length'], 'string', 'max' => 100],
				//[['area', 'street_name', 'longitude', 'lattitude', 'room_type', 'real_estate_interface', 'street_view', 'limits_length_property'], 'string', 'max' => 50],
                [['space'], 'string', 'max' => 50],
				[['furniture', 'ad_description'], 'string', 'max' => 400],
				[['status','rooms','entrances','toilets','conditioner_num' ,'has_parking', 'kitchen','width','length'  , 'ad_subtype'], 'default', 'value' => 0],
				//[['electricity_meter_no', 'advertiser_side', 'advertiser_adjective', 'advertiser_license_number', 'advertiser_name', 'advertiser_email', 'advertiser_mobile', 'advertiser_registration_number','authorization_number'], 'string', 'max' => 50],
                [['electricity_meter_no'], 'string', 'max' => 50],
				[['detail'], 'string', 'max' => 500],
			];
		}
  
		

		/**
		 * {@inheritdoc}
		 */
		public function attributeLabels()
		{
			return [
				'id' => Yii::t('app', 'ID'),
				'building_id' => Yii::t('app', 'Building ID'),
				'housing_unit_name' => Yii::t('app', 'Housing Unit Name'),
				'floors_no' => Yii::t('app', 'Floors No'),
				'building_type_id' => Yii::t('app', 'Building Type'),
				'rent_price' => Yii::t('app', 'Rent Price'),
				'area' => Yii::t('app', 'Area'),
				'space' => Yii::t('app', 'Space'),
				'rooms' => Yii::t('app', 'Rooms'),
				'invest_price' => Yii::t('app', 'Invest Price'),
				'entrances' => Yii::t('app', 'Entrances'),
				'has_parking' => Yii::t('app', 'Has Parking'),
				'toilets' => Yii::t('app', 'Toilets'),
				'kitchen' => Yii::t('app', 'Kitchen'),
				'furniture' => Yii::t('app', 'Furniture'),
				'conditioner_num' => Yii::t('app', 'Conditioner Num'),
				'pool' => Yii::t('app', 'Pool'),
				'ad_description' => Yii::t('app', 'Ad Description'),
				'room_type' => Yii::t('app', 'Room Type'),
				'lounge' => Yii::t('app', 'Lounge'),
				'detail' => Yii::t('app', 'Detail'),
				'using_for' => Yii::t('app', 'Using For'),
				'status' => Yii::t('app', 'Status'),
				'for_rent' => Yii::t('app', 'For Rent'),
				'for_sale' => Yii::t('app', 'For Sale'),
				'for_invest' => Yii::t('app', 'For Invest'),
				'sale_price' => Yii::t('app', 'Sale Price'),
				'electricity_meter_no' => Yii::t('app', 'Electricity Meter Number'),
				'width' => Yii::t('app', 'Width'),
				'length' => Yii::t('app', 'Length'),
				'ad_subtype' => Yii::t('app', 'Ad Sub Type'),
				'ad_description' => Yii::t('app', 'Title Ads'),
				'ad_status' => Yii::t('app', 'Status Ad'),
				'ad_publish_date' => Yii::t('app', 'Publication Date'),
				'ad_expire_date' => Yii::t('app', 'Expiration Date'),



			];
		}



		public static function ListHousingByBuilding($building=0)
		{
			if ($building!=0)
				$droptions = BuildingHousingUnit::find()->where(['building_id'=>$building])->asArray()->all();
			else
				$droptions = array();

			return  \yii\helpers\Arrayhelper::map($droptions, 'id', 'housing_unit_name');
		}

		public static function ListHousingByBuildingUnrented($building=0)
		{
			if ($building!=0)
				$droptions = BuildingHousingUnit::find()->where(['building_id'=>$building])->rented(false)->asArray()->all();
			else
				$droptions = array();

			return  \yii\helpers\Arrayhelper::map($droptions, 'id', 'housing_unit_name');
		}


		public function beforeDelete()
		{
			if(parent::beforeDelete()) {
				$result = 
				($this->contract) ? 'Contracts': (
					(OrderInfo::class::find()->where(['building_housing_unit_id' => $this->id])->one())? 'Order Infos': (
					(ReceiptVoucher::class::find()->where(['building_housing_unit_id' => $this->id])->one()) ? 'Receipt Vouchers' :
						null)); 
				if($result !== null){
					Yii::$app->session->setFlash('danger',
						yii::t('app','cannot delete {item} has items from {items}.',[
							'item' =>yii::t('app','Housing Unit') ,'items' => yii::t('app',$result)
						])
					);
					return false;
				}  
				Yii::$app->session->setFlash('success', Yii::t('app','Deletes are done successfully.'));
				return true;
			} 

			return false;

		}


	public function date()
    {
        // $date = \common\components\GeneralHelpers::formatDate($this->ad_publish_date)[0];
        $date = '';
        $date .= ' '. \common\components\GeneralHelpers::formatDate($this->ad_publish_date)[0];
        return $date;
    }

		public function getContract()
		{
			return $this->hasOne(Contract::class, ['housing_unit_id' => 'id']);
		}

		public function getBuilding()
		{
			return $this->hasOne(Building::class, ['id' => 'building_id']);
		}
		public function getBuildingType()
		{
			return $this->hasOne(BuildingType::class, ['id' => 'building_type_id']);
		}

		public function eventViewRenterAndPay($event , $isNew = false){
		// if status housing not rented
			if($this->status == 0){
				$attributes = ['for_rent','for_sale','for_invest'];
				foreach ($attributes as $row) {
					if( $this->$row == 1 && ($isNew || $this->getOldAttribute($row) != $this->$row)){
						$status = $this->attributeLabels()[$row];

						if($row == 'for_invest')
							$ad_subtype = 0;
						elseif ($row == 'for_rent')
							$ad_subtype = 2;
						else 
							$ad_subtype = 1;

				        $urlParams =http_build_query(['id' =>  $this->id,'type'=>$ad_subtype]);
						$link = Yii::$app->BaseUrl->baseUrl. '/gallery/housing?'. $urlParams;
				        // $link = Html::a(yii::t('app','Click me'), $link,['target'=>'_blank']);
				        
					$params = [
						're_id' => $this->building->estateContract->estate_office_id ,
						're_type' => 'estate_officer' ,
						'content' => 'Housing view for renter Or pay' ,
						'id' => $this->id,
						't_name' => 'building-housing-unit',
						'mobile' => $this->building->estateContract->estateOffice->mobile,
						'email' => $this->building->estateContract->estateOffice->email,
						
						'building_name' => $this->housing_unit_name,
						'estate_office_name' =>  $this->building->estateContract->estateOffice->name,
						'owner_name' => $this->building->owner->name,
						'status_view' => $status,
					];
					\common\components\GeneralHelpers::sendNotif(Building::NOTIF_TEMP_VIEW_RENTER_PAY_ESTATE,$params,$this->building->estateContract->estateOffice->id);
					// $owners = \common\models\User::find()->where(['or',['user_type'=>'owner'],['owner'=>1]])->all();
					$owner = $this->building->owner;
						
						$params = [
							're_id' => $owner->id ,
							're_type' => 'owner' ,
							'content' => 'Housing view for renter Or pay' ,
							'id' => $this->id,
							't_name' => 'building-housing-unit',
							'mobile' => $owner->mobile,
							'email' => $owner->email,
							
							'building_name' => $this->housing_unit_name,
							'estate_office_name' =>  $this->building->estateContract->estateOffice->name,
							'owner_name' => $this->building->owner->name,
							'status_view' => $status,
							'url' => $link,
						];

						\common\components\GeneralHelpers::sendNotif(Building::NOTIF_TEMP_VIEW_RENTER_PAY_OWNERS,$params,$this->building->estateContract->estateOffice->id);

				};
				};
			}
		}

		public function eventNew()
		{
			$this->eventViewRenterAndPay(null,true);

		}

	}
