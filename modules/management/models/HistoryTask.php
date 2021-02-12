<?php

namespace modules\management\models;

use olympic\models\auth\Profiles;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use function GuzzleHttp\Psr7\normalize_header;

/**
 * This is the model class for table "{{%history_task}}".
 *
 * @property json $before
 * @property json $after
 * @property integer $task_id
 * @property integer $created_by
 * @property integer $created_at
 **/

class HistoryTask extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%history_task}}';
    }


    public static function create($before, $after, $task_id, $user_id)
    {
        $history = new static();
        $history->before = $before;
        $history->after = $after;
        $history->task_id = $task_id;
        $history->created_by = $user_id;
        $history->created_at = date("Y-m-d H:i:s");
        return $history;
    }

    public function getBeforeData()
    {
        return $this->before ? Json::decode($this->before) : null;
    }

    public function getAfterData()
    {
        return $this->after ? Json::decode($this->after) : null;
    }

    public function getBefore($key)
    {
        return ArrayHelper::getValue($this->getBeforeData(), $key);
    }

    public function getAfter($key)
    {
        return ArrayHelper::getValue($this->getAfterData(), $key);
    }

    public function isIdenticalValue($key, $value) {
        return $this->getBefore($key) == $value;
    }

    public function getProfile() {
        return $this->hasOne(Profiles::class, ['user_id' => 'created_by']);
    }

    public function attributesValue($value): array
    {
        $dicTask = DictTask::findOne($value);
        $profile = Profiles::findOne(['user_id'=> $value]);
        $list = (new Task())->getStatusList();
        return [
            "title" => $value,
            "text" => $value,
            'dict_task_id' => $dicTask  ? $dicTask->name : null,
            'director_user_id' => $profile  ? $profile->getFio() : null,
            'responsible_user_id' =>  $profile  ? $profile->getFio() : null,
            'date_begin' => $value,
            'status' => key_exists($value, $list) ? $list[$value]['name']: null,
            'position' => $value,
            'date_end' =>  $value,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'task_id' => 'Задача',
            'created_by' => "Кто создал?",
            'created_at' => "Дата создания",
        ];
    }

}