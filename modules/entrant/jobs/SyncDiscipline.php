<?php


namespace modules\entrant\jobs;

use api\client\Client;
use modules\entrant\services\UserDisciplineService;
use yii\base\BaseObject;

class SyncDiscipline extends BaseObject implements \yii\queue\JobInterface
{
    private $service;

    public $url;
    public $type;
    const SYNC_INCOMING = 1;
    const SYNC_APP = 2;


    public function __construct(UserDisciplineService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($config);
    }

    public function execute($queue)
    {
        $result = (new Client())->postData($this->url, $this->type);
        if ($result) {
            $this->service->updateStatuses($result);
        }
    }
}