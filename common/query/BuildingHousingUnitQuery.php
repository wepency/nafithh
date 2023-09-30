<?php
namespace common\query;

use yii\db\ActiveQuery;

class BuildingHousingUnitQuery extends ActiveQuery
{
    // conditions appended by default (can be skipped)
    // public function init()
    // {
    //     $this->andOnCondition(['is_draft' => 0]);
    //     parent::init();
    // }

    // ... add customized query methods here ...

    public function rented($state = true)
    {
        return $this->andOnCondition(['status' => $state]);
    }

}

?>