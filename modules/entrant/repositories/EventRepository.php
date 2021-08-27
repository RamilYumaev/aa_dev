<?php


namespace modules\entrant\repositories;


use modules\entrant\models\Event;
use modules\usecase\RepositoryClass;

class EventRepository extends RepositoryClass
{
    public function __construct(Event $model)
    {
        $this->model = $model;
    }


}