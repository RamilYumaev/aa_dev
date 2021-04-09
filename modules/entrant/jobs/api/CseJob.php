<?php


namespace modules\entrant\jobs\api;
use api\client\Client;
use modules\entrant\services\UserDisciplineService;
use yii\base\BaseObject;

class CseJob extends BaseObject implements \yii\queue\JobInterface
{
    private $service;

    public $url;
    public $data;

    public function __construct(UserDisciplineService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($config);
    }

    public function execute($queue)
    {
        $result =  (new Client())->postData($this->url, $this->data);
        if ($result) {
            $this->service->updateStatuses(json_decode($result));
        }
    }
}