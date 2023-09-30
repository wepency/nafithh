<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "notification".
 *
 * @property int $id
 * @property string|null $notification_type
 * @property int $receiver_id
 * @property string $receiver_type
 * @property string $content
 * @property int $subject_id
 * @property string $table_name
 * @property string $created_at
 * @property string|null $readed_at
 * @property int $status_read
 */
class Notification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['receiver_id', 'receiver_type', 'content', 'subject_id', 'table_name'], 'required'],
            [['receiver_id', 'subject_id', 'status_read'], 'integer'],
            [['created_at', 'readed_at'], 'safe'],
            ['status_read', 'default', 'value' => 0], 
            ['receiver_type', 'in', 'range' => array_diff_key(yii::$app->params['userType']['key'],[1,3,5,8])],
            [['notification_type'], 'string', 'max' => 200],
            [['receiver_type'], 'string', 'max' => 30],
            [['content'], 'string', 'max' => 5000],
            [['table_name'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'notification_type' => Yii::t('app', 'Notification Type'),
            'receiver_id' => Yii::t('app', 'Receiver ID'),
            'receiver_type' => Yii::t('app', 'Receiver Type'),
            'content' => Yii::t('app', 'Content'),
            'subject_id' => Yii::t('app', 'Subject ID'),
            'table_name' => Yii::t('app', 'Table Name'),
            'created_at' => Yii::t('app', 'Created At'),
            'readed_at' => Yii::t('app', 'Readed At'),
            'status_read' => Yii::t('app', 'Status Read'),
        ];
    }


    public static function find()
    {
        $currentUser = \common\models\Chat::getInfoUser();
        return parent::find()->andwhere(['receiver_id' => $currentUser['userId'] ,'receiver_type'=>$currentUser['userType']])->orderBy(['status_read'=>SORT_ASC,'id' =>SORT_DESC]);
    }


    public static function getUnread()
    {
        $currentUser = \common\models\Chat::getInfoUser();
        return self::find()->andwhere(['status_read' => 0])->all();
    }


    /*
    for used
     \common\models\Notification::addNew(['re_id' => ,'re_type' => ,'content' => ,'su_id' => ,'t_name' => ]);
     examlpe :
      \common\models\Notification::addNew(['re_id' => $user_id ,'re_type' => 'owner' ,'content' => yii::t('app','create new') ,'su_id' => $model->id,'t_name' => 'contract' ]);
    */
    public static function addNew(array $data)
    {
        $dd = Yii::$app->db->createCommand()->insert('notification',[
            'receiver_id' => $data['re_id'],
            'receiver_type' => $data['re_type'],
            'content' => $data['content'],
            'subject_id' => $data['id'],
            'table_name' => $data['t_name'],
            'status_read' => 0,
        ])->execute();
        // print_r($dd); die();
    }
}
