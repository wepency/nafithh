<?php

namespace common\query;

/**
 * This is the ActiveQuery class for [[ChatHistory]].
 *
 * @see ChatHistory
 */
class ChatHistoryQuery extends \yii\db\ActiveQuery
{
    public function unread()
    {
        return $this->andWhere(['status_read'=>0]);
    }

    /**
     * {@inheritdoc}
     * @return ChatHistory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ChatHistory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function first($db = null)
    {
        return $this->OrderBy(['id'=>SORT_ASC])->one();
    }


}
