<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "takamolat".
 *
 * @property int $adLicenseNumber
 * @property int $advertiserId
 * @property int $adType
 */

class Takamolat extends Model
{
    public $adLicenseNumber;
    public $advertiserId;
    public $adType;

    public function rules()
    {
        return [
            [['adType'], 'required'],
            [['advertiserId'], 'required'],
            [['adLicenseNumber'], 'required'],
            [['adLicenseNumber'], 'validateAdLicenseNumber'],
        ];
    }

    public function validateAdLicenseNumber($attribute, $params)
    {
        $data = json_decode($this->$attribute, true);

        if (!is_array($data) || empty($data)) {
            $this->addError($attribute, 'Invalid JSON format for adLicenseNumber.');
            return;
        }

        foreach ($data as $item) {
            if (!isset($item['key'], $item['value'], $item['equals']) ||
                !is_bool($item['equals'])) {
                $this->addError($attribute, 'Invalid format for adLicenseNumber array items.');
                return;
            }
        }
    }
}