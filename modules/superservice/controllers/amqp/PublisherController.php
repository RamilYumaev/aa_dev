<?php
namespace modules\superservice\controllers\amqp;

use modules\superservice\amqp\Publisher;
use modules\superservice\amqp\Serializer;
use modules\superservice\models\dto\request\Message;
use modules\superservice\models\Test;
use yii\console\Controller;

class PublisherController extends Controller
{
    private $publisher;
    private $serializer;

    public function __construct($id, $module, Publisher $publisher, Serializer $serializer, $config = [])
    {
        $this->publisher = $publisher;
        $this->serializer = $serializer;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex(): void
    {
        $test = new Test();
        $test->setInternalId(450)
            ->setName("Marek")
            ->setYearStart(2015)
            ->setYearEnd(2016)
            ->setCampaignTypeId(5)
            ->setCampaignStatusId(5)
            ->setMaxCountAchievements(10)
            ->setNumberAgree(3)
            ->setCountDirections(3)
            ->setEndDate(new \DateTime());

        $this->publisher->publish(new Message($this->serializer->serialize($test)),'regular_exchange', 'to_superservice_request');
    }
}