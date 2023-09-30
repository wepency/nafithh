<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "attachment".
 *
 * @property int $id
 * @property int $item_id
 * @property string $item_type 	/ building, housing_unit,owner.
 * @property string $file
 * @property string $type
 * @property int $size
 */
class Attachment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attachment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id', 'item_type', 'file', 'type', 'size'], 'required'],
            [['item_id', 'size'], 'integer'],
            [['item_type', 'type'], 'string', 'max' => 200],
            [['file'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'item_id' => Yii::t('app', 'Item ID'),
            'item_type' => Yii::t('app', 'Item Type'),
            'file' => Yii::t('app', 'File'),
            'type' => Yii::t('app', 'Type'),
            'size' => Yii::t('app', 'Size'),
        ];
    }
}
