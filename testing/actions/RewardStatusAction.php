<?php
namespace testing\actions;

use testing\helpers\TestAttemptHelper;
use testing\models\TestAttempt;
use testing\repositories\TestAttemptRepository;
use testing\services\TestAttemptService;
use yii\base\Action;
use Yii;

class RewardStatusAction extends  Action
{
    /* @var  $testAttempt TestAttempt */
    private $testAttempt;
    private $service;
    public  $rewardStatus;

    public function __construct($id, $controller, TestAttemptService $service,
                                TestAttemptRepository $repository, $config = [])
    {
        parent::__construct($id, $controller, $config);
        $this->testAttempt = $repository->get(\Yii::$app->request->get('id'));
        $this->service= $service;
    }

    public function run()
    {
        try {
            if($this->rewardStatus == TestAttemptHelper::NOMINATION) {
                $this->service->nomination($this->testAttempt->id, \Yii::$app->request->get('nominationId'));
            }
            elseif($this->rewardStatus == TestAttemptHelper::REWARD_NULL) {
                $this->service->removeAllStatuses($this->testAttempt->id);
            }
            else {
                $this->service->rewardStatus($this->testAttempt->id, $this->rewardStatus);
            }
            if (Yii::$app->request->isAjax) {
                return $this->renderList();
            }
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->controller->redirect(['index', 'test_id' =>  $this->testAttempt->test_id]);
    }

    protected function renderList()
    {
        $method = Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        return $this->$method('index',  [ 'test_id' =>  $this->testAttempt->test_id]);
    }

}