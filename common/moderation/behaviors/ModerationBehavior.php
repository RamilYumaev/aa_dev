<?php

namespace common\moderation\behaviors;
use common\moderation\helpers\ModerationHelper;
use common\moderation\repositories\ModerationRepository;
use yii\base\Behavior;
use common\moderation\models\Moderation as ModelModeration;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\helpers\Json;

class ModerationBehavior extends  Behavior
{
    public $attributes = [];
    /**
     * @var BaseActiveRecord
     */
    public $owner;


    private $repository;

    public function __construct( ModerationRepository $repository, $config = [])
    {
        $this->repository = $repository;
        parent::__construct($config);
    }

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
        if ($this->isNoNewsAndOld($old)) {
            if (!$this->emptyCount($old)) {
                $this->moderation($old);
            }
        }
    }

    protected function moderation(array $old) {

        $moderation = ModelModeration::create(
            $this->owner::className(),
            $this->owner->id,
            $this->old($old),
            $this->news());

        $this->repository->save($moderation);
    }

    protected function  allowedKeysAttribute ($data)
    {
        return Json::encode($this->arrayIntersectKey($data), JSON_NUMERIC_CHECK);
    }

    protected  function  arrayIntersectKey ($data) {
        return array_intersect_key($data, array_flip($this->attributes));
    }

    protected function old(array $old)
    {
        return $this->allowedKeysAttribute($old);
    }

    protected function news()
    {
       return $this->allowedKeysAttribute($this->owner->attributes);
    }

    protected function isNoNewsAndOld(array $old){
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
        foreach ($this-> arrayIntersectKey($old) as $value) {
            if (empty($value)) {
                $count++;
            }
        }

        return count($this->attributes) == $count;
    }

}