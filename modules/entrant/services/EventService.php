<?php


namespace modules\entrant\services;

use modules\entrant\forms\EventForm;
use modules\entrant\models\Event;
use modules\entrant\models\EventCg;
use modules\entrant\repositories\EventRepository;
use modules\usecase\ServicesClass;
use yii\base\Model;

class EventService extends ServicesClass
{
    public function __construct(EventRepository $repository, Event $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }

    public function create(Model $form)
    {
        $model = parent::create($form);
        $this->addRelationEvent($model->id, $form);
        return $model;
    }

    public function edit($id, Model $form)
    {
        parent::edit($id, $form);
        EventCg::deleteAll(['event_id'=>$id]);
        $this->addRelationEvent($id, $form);
    }

    protected function addRelationEvent($id, Model $form) {
        /**
         * @var $form EventForm
         */
        if($form->cg_id) {
            foreach ($form->cg_id as $cg) {
                $model = EventCg::create($cg, $id);
                $model->save();
            }
        }
    }
}