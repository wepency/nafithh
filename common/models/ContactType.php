<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "contact_type".
 *
 * @property int $id
 * @property string $title
 * @property string $title_en
 * @property int $sort_at
 */
class ContactType extends \yii\db\ActiveRecord
{

    public $_title;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contact_type';
    }

    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'title_en'], 'required'],
            [['sort_at'], 'integer'],
            [['sort_at'], 'default','value'=>0],
            [['title', 'title_en'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'title_en' => Yii::t('app', 'Title En'),
            'sort_at' => Yii::t('app', 'Sort At'),
        ];
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $result = ($this->contactUs)? 'Contact Us': null;  
            if($result !== null){
                Yii::$app->session->setFlash('danger',
                    yii::t('app','cannot delete {item} has items from {items}.',[
                        'item' =>yii::t('app','Contact Type') ,'items' => yii::t('app',$result)
                    ])
                );
                return false;
            }

            Yii::$app->session->setFlash('success', Yii::t('app','Deletes are done successfully.'));
            return true;
        } 
        return false;
    }

    public function getContactUs(){
        return $this->hasMany(ContactUs::class, ['contact_type_id' => 'id']);
    }

    public function afterFind()
    {
        parent::afterFind();
        if (Yii::$app->language=='ar'){
            $this->_title = $this->title;
        }else{
            $this->_title = $this->title_en;
        }
    }
}
