<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "contract_form_estate_office".
 *
 * @property int $id
 * @property int $estate_office_id
 * @property int $contract_form_id
 * @property string $contract_form_name
 * @property string $contract_form_name_en
 * @property string $contract_form_text
 * @property string $contract_form_text_en
 * @property int $status
 */
class ContractFormEstateOffice extends \yii\db\ActiveRecord
{
    public $_name;
    public $_text;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contract_form_estate_office';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estate_office_id', 'contract_form_name', 'contract_form_name_en', 'contract_form_text', 'contract_form_text_en', 'status'], 'required'],
            [['estate_office_id', 'contract_form_id', 'status'], 'integer'],
            [['contract_form_id'], 'default', 'value' => 0],
            [['contract_form_text', 'contract_form_text_en'], 'string'],
            [['contract_form_name', 'contract_form_name_en'], 'string', 'max' => 200],
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
            'contract_form_id' => Yii::t('app', 'Contract Form'),
            'contract_form_name' => Yii::t('app', 'Name'),
            'contract_form_name_en' => Yii::t('app', 'Name En'),
            'contract_form_text' => Yii::t('app', 'Text'),
            'contract_form_text_en' => Yii::t('app', 'Text En'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    public function afterFind()
    {
        parent::afterFind();
        if (Yii::$app->language=='ar'){
            $this->_name = $this->contract_form_name;
            $this->_text = $this->contract_form_text;
        }else{
            $this->_name = $this->contract_form_name_en;
            $this->_text = $this->contract_form_text_en;
        }
    }

    public function beforeDelete()
    {
        $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();

        if (parent::beforeDelete()) {
            $result = 
                (Contract::class::find()->where(['contract_form_id'=> $this->id,'estate_office_id' => $estate_office_id])->one()) ? 'Contracts': null;
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
