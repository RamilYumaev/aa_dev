<?php
namespace modules\entrant\widgets\statement;


use modules\entrant\models\Statement;
use modules\entrant\services\StatementPersonalDataService;
use modules\entrant\services\StatementService;
use yii\base\Widget;
use Yii;

class StatementPersonalDataWidget extends Widget
{
    public $userId;

    private $service;

    public function __construct(StatementPersonalDataService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($config);
    }

    public function init()
    {
        try {
            $this->service->create($this->userId);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    public function run()
    {
        return $this->render('index-pd', [
            'statement'=> $this->service->repository->get($this->userId),
        ]);
    }
}
