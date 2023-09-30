<?php

namespace common\query;

/**
 * This is the ActiveQuery class for [[Chat]].
 *
 * @see Chat
 */
class ChatQuery extends \yii\db\ActiveQuery
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
        return $this->andOnCondition(['or',
            ['sender_type' => $info['userType'],'sender_id' => $info['userId']],
            ['receiver_type' => $info['userType'],'receiver_id' => $info['userId']],
        ]);
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
