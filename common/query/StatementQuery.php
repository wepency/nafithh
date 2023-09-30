<?php

namespace common\query;

/**
 * This is the ActiveQuery class for [[\common\models\Statement]].
 *
 * @see \common\models\Statement
 */
class StatementQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\Statement[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Statement|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
