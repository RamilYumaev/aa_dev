<?php

namespace modules\entrant\models;

use dictionary\models\DictCompetitiveGroup;
use Yii;

/**
 * This is the model class for table "event_cg".
 *
 * @property int $cg_id
 * @property int $event_id
 *
 * @property DictCompetitiveGroup $cg
 * @property Event $event
 */
class EventCg extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_cg';
    }

    public static function create($cg_id, $event_id) {
        $model = new static();
        $model->event_id = $event_id;
        $model->cg_id = $cg_id;
        return $model;
    }

    /**
     * Gets query for [[Cg]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCg()
    {
        return $this->hasOne(DictCompetitiveGroup::className(), ['id' => 'cg_id']);
    }

    /**
     * Gets query for [[Event]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::className(), ['id' => 'event_id']);
    }
}
