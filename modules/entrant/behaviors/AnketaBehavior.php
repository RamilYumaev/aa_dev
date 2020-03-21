<?php

namespace modules\entrant\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;


class ModerationBehavior extends  Behavior
{

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
        ];
    }

    /**
     * @param $event
     */
    public function beforeUpdate($event)
    {
        $this->find();
        $old = $this->owner->oldAttributes;
        if ($this->isNoNewAndOld($old)) {
            if (!$this->emptyCount($old)) {
                $this->moderation($old);
            }
        }
    }

    /**
     * @param $event
     */
    public function beforeDelete($event)
    {
        ModelModeration::deleteAll(['model'=> $this->owner::className(), 'record_id' =>  $this->owner->id]);
    }

    protected function moderation(array $old) {

        $moderation = ModelModeration::create(
            $this->owner::className(),
            $this->owner->id,
            $this->old($old),
            $this->news());

        $this->repository->save($moderation);
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

    protected function new()
    {
        return $this->encoding($this->owner->attributes);
    }
    protected function old(array $old)
    {
        return $this->encoding($old);
    }

    protected function isNoNewAndOld(array $old){
        return  $this->old($old) != $this->news();
    }

    protected  function find () {
        if (ModelModeration::find()->andWhere(['model'=> $this->owner::className(),
            'record_id' =>  $this->owner->id,
            "status" => ModerationHelper::STATUS_NEW])->exists()) {
            throw  new  \DomainException("Измененные данные находятся на модерации");
        }
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