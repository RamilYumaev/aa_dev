<?php

namespace olympic\models\behaviors;

use common\auth\models\DeclinationFio;
use common\auth\repositories\DeclinationFioRepository;
use olympic\helpers\auth\ProfileHelper;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;

class DeclinationBehavior extends  Behavior
{
    /**
     * @var BaseActiveRecord
     */
    public $owner;
    private $repository;

    public function __construct(DeclinationFioRepository $repository,$config = [])
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
        ActiveRecord::EVENT_AFTER_UPDATE=> 'afterUpdate',
        ];
    }

    /**
     * @param $event
     * @throws \Exception
     */
    public function afterUpdate($event)
    {
        if (!is_null($this->owner->fio)) {
            $declination = $this->repository->findByUserId($this->owner->user_id);
            if ($declination) {
                $declination->data($this->owner->fio);
            }else {
                $declination = DeclinationFio::defaultCreate($this->owner->fio, $this->owner->user_id);
            }
            $this->repository->save($declination);
        }
    }

}