<?php


namespace modules\exam\jobs;
use api\client\Client;
use modules\entrant\services\UserDisciplineService;
use modules\exam\services\ExamStatementService;
use yii\base\BaseObject;

class StatementExamJob extends BaseObject implements \yii\queue\JobInterface
{
    private $service;

    public $eduLevel;
    public $formCategory;

    public function __construct(ExamStatementService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($config);
    }

    public function execute($queue)
    {
        $this->service->addAllStatement($this->eduLevel, $this->formCategory);
    }
}