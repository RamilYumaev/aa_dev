<?php
namespace modules\entrant\widgets\statement;


use modules\entrant\models\Statement;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\services\StatementIndividualAchievementsService;
use modules\entrant\services\StatementService;
use yii\base\Widget;
use Yii;

class StatementIaWidget extends Widget
{
    public $userId;

    private $service;

    public function __construct(StatementIndividualAchievementsService $service, $config = [])
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
        $model = StatementIndividualAchievements::find()->user($this->userId)->all();
        return $this->render('index-ia', [
            'statementsIa'=> $model,
        ]);
    }
}
