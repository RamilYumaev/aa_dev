<?php
namespace modules\entrant\widgets\statement;


use modules\entrant\models\Statement;
use modules\entrant\services\StatementService;
use yii\base\Widget;
use Yii;

class StatementWidget extends Widget
{
    public $facultyId, $specialityId, $specialRight, $eduLevel, $userId, $formCategory;

    private $service;

    public function __construct(StatementService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($config);
    }

    public function init()
    {
        try {
            $this->service->create($this->facultyId,
                $this->specialityId,
                $this->specialRight,
                $this->eduLevel,
                $this->userId,
                $this->formCategory);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    public function run()
    {
        $model = Statement::find()->defaultWhereNoStatus(
            $this->facultyId,
            $this->specialityId,
            $this->specialRight,
            $this->eduLevel,
            $this->formCategory)
            ->user($this->userId)
            ->all();
        return $this->render('index', [
            'statements'=> $model,
        ]);
    }
}
