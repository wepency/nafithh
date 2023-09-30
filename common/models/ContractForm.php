<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "contract_form".
 *
 * @property int $id
 * @property string $name
 * @property string $name_en
 * @property string $body
 * @property string $body_en
 * @property int $status
 */
class ContractForm extends \yii\db\ActiveRecord
{
    public $_name;
    public $_body;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contract_form';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'name_en', 'body', 'body_en', 'status'], 'required'],
            [['body', 'body_en'], 'string'],
            [['status'], 'integer'],
            [['name', 'name_en'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'name_en' => Yii::t('app', 'Name En'),
            'body' => Yii::t('app', 'Body'),
            'body_en' => Yii::t('app', 'Body En'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
    public function afterFind()
    {
        parent::afterFind();
        if (Yii::$app->language=='ar'){
            $this->_name = $this->name;
            $this->_body = $this->body;
        }else{
            $this->_body = $this->body_en;
            $this->_name = $this->name_en;
        }
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $result = (ContractFormEstateOffice::class::find()->where(['contract_form_id' => $this->id])->one())? 'Contract Forms Estate Offices': null;  
            if($result !== null){
                Yii::$app->session->setFlash('danger',
                  yii::t('app','cannot delete {item} has items from {items}.',[
                    'item' =>yii::t('app','Contract Form') ,'items' => yii::t('app',$result)
                  ])
                );
                return false;
            }

            Yii::$app->session->setFlash('success', Yii::t('app','Deletes are done successfully.'));
            return true;
        } 
        return false;
    }

}
