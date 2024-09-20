<?php
namespace common\query;

use yii\db\ActiveQuery;

class ContractQuery extends ActiveQuery
{
    // conditions appended by default (can be skipped)
    public function init()
    {
        $this->andOnCondition('is_draft = :is_draft', [':is_draft' => 0]);
        parent::init();
    }

    // ... add customized query methods here ...

    public function active($state =1)
    {
        return $this->andWhere(['is_active' => $state]);
    }

    public function currentOffice($estate_office_id = null)
    {
        if(!$estate_office_id){
            $estate_office_id = \common\components\GeneralHelpers::getEstateOfficeId();
        }
        if($estate_office_id){
            return $this->andWhere(['contract.estate_office_id' => $estate_office_id]);
        }
        return $this;
    }

    public function withDraft() {
        $this->onCondition(null);
        unset($this->params[':is_draft']);
        // $this->onCondition(null);
        // remove unused param from old ON condition
        // $this->andOnCondition(null);
        // unset($this->params[':building_id']);

        return $this;
    }
}

?>