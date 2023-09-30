<?php

namespace common\query;

/**
 * This is the ActiveQuery class for [[Chat]].
 *
 * @see Chat
 */
class GlobalQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Chat[]|array
     */
    // public function all($db = null)
    // {
    //     return parent::all($db);
    // }

    public function CurrentUser()
    {
        $info = \common\models\Chat::getInfoUser();
        switch ($info['userType']) {
            case 'owner':
                return $this->andOnCondition(['owner_id' => $info['userId']]);
                break;
            case 'estate_officer':
                $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
                $andFilter = [
                    'estate_office_building.estate_office_id' => $estate_office_id,
                    'estate_office_building.is_active' => 1
                ];
                return $this->joinWith('estateContract')->andWhere($andFilter);
                break;
            
            default:
                return $this;
                break;
        }
    }

    /**
     * {@inheritdoc}
     * @return Chat|array|null
     */
    // public function one($db = null)
    // {
    //     return parent::one($db);
    // }
}
