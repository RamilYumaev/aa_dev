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
        ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
        ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
        ];
    }

    /**
     * @param $event
     */
    public function afterInsert($event)
    {
        $this->moderation();
    }

    /**
     * @param $event
     */
    public function beforeUpdate($event)
    {
        $this->find();

        $old = $this->owner->oldAttributes;
        if ($this->isNoNewsAndOld($old)) {
            $this->moderation($old);
        }
    }

    protected function moderation(array $old = null) {

        $moderation = ModelModeration::create(
            $this->owner::className(),
            $this->owner->id,
            $old ? $this->old($old) : null,
            $this->news());

        $this->repository->save($moderation);
    }

    protected function  allowedKeysAttribute ($data)
    {
        return Json::encode(array_intersect_key($data, array_flip($this->attributes)), JSON_NUMERIC_CHECK);
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
            throw  new  \DomainException("Модерация еще не пройдена");
        }

    }

}