<?php

namespace modules\management\behaviors;
use modules\management\models\HistoryTask;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class HistoryTaskBehavior extends  Behavior
{
    public $attributes = [];
    public $attributesNoEncode = [];

    /**
     * @var BaseActiveRecord
     */
    public $owner;

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
        ];
    }

    /**
     * @param $event
     */
    public function beforeUpdate($event)
    {
        $old = $this->owner->oldAttributes;
        if ($this->isNoNewsAndOld($old)) {
            if (!$this->emptyCount($old)) {
                $this->moderation($old);
            }
        }
    }

    /**
     * @param $event
     */
    public function afterInsert($event)
    {
        $history = HistoryTask::create(
            [],
            [],
            $this->owner->id,
            $this->getUserId());
        $history->save();
    }

    protected function moderation(array $old) {

        $history = HistoryTask::create(
            $this->old($old),
            $this->news(),
            $this->owner->id,
            $this->getUserId());

        $history->save();
    }

    private function getUserId() {

        return \Yii::$app->user->identity->getId();
    }


    protected function allowedKeysAttribute($data, $attributes, $type = 320)
    {
        return Json::encode($this->arrayIntersectKey($data, $attributes), $type);
    }

    protected  function  arrayIntersectKey ($data, $attributes) {
        return array_intersect_key($data, array_flip($attributes));
    }

    protected function encoding(array $data)
    {
        $encode = $this->allowedKeysAttribute($data, $this->attributes, JSON_NUMERIC_CHECK);
        if ($this->attributesNoEncode) {
            $attributeNoEncode = $this->allowedKeysAttribute($data, $this->attributesNoEncode);
            $a = Json::decode($encode);
            $b = Json::decode($attributeNoEncode);
            return Json::encode(ArrayHelper::merge($a, $b));
        }
        return $encode;
    }

    protected function news()
    {
       return $this->encoding($this->owner->attributes);
    }

    protected function old(array $old)
    {
        return $this->encoding($old);
    }

    protected function isNoNewsAndOld(array $old){

        return  $this->arrayIntersectKey ($old, $this->attributes) !=
            $this->arrayIntersectKey ($this->owner->attributes,$this->attributes);
    }


    private function emptyCount(array $old) : bool
    {
        $count = 0;
        foreach ($this->arrayIntersectKey($old, $this->attributes) as $value) {
            if (empty($value)) {
                $count++;
            }
        }

        return count($this->attributes) == $count;
    }

}