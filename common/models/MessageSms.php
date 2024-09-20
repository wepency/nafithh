<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "message_sms".
 *
 * @property int $id
 * @property string $message
 * @property string $numbers
 * @property int|null $user_created_id
 * @property string|null $created_date
 */
class MessageSms extends \yii\db\ActiveRecord
{
    public $modelNumber;
    public $groups;

    public function behaviors()
    {
        return [
            [
            'class' => 'yii\behaviors\BlameableBehavior',
            'attributes' =>
                [
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => 'user_created_id',
                ],
            'value' => function(){
                return Yii::$app->user->identity->id;
            }
        ], 
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message_sms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message'], 'required'],
            [['numbers'], 'string'],
            [['user_created_id'], 'integer'],
            [['created_date'], 'safe'],
            [['message'], 'string', 'max' => 500],
            [['user_created_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_created_id' => 'id']],
            [['to_group'], 'string', 'max' => 255],

            [['groups'], 'each', 'rule' => ['string'], 'skipOnError' => true],
            [['modelNumber'], 'each', 'rule' => ['integer'], 'skipOnError' => true],
            [['modelNumber'], 'each', 'rule' => ['match', 'pattern' => '/^(5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/' ,'message'=>yii::t('app','5xxxxxxxx')], 'skipOnError' => true],

            [['groups','modelNumber'], 'required', 'when' => function($model) {
                return $model->groups == null && $model->modelNumber == null;
            }, 'whenClient' => "function (attribute, value) {
                return jQuery.isEmptyObject($('#messagesms-groups').val()) && jQuery.isEmptyObject($('#messagesms-modelnumber').val()) ;
            }", 'message' => yii::t('app','You must enter a Grops or Numbers')],

            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'message' => Yii::t('app', 'Message'),
            'numbers' => Yii::t('app', 'Numbers Mobile'),
            'user_created_id' => Yii::t('app', 'User Created'),
            'to_group' => Yii::t('app', 'To Group'),
            'created_date' => Yii::t('app', 'Created Date'),
        ];
    }

    public function getUserCreated()
    {
        return $this->hasOne(User::class, ['id' => 'user_created_id']);
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->groups)
                $this->to_group = implode(",",$this->groups);
            return true;
        } else {
            return false;
        }
    }

    public function afterFind()
    {
        parent::afterFind();
        if($this->to_group)
        $this->groups = explode(",",$this->to_group);
    }
}
