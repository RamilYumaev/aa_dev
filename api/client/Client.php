<?php

namespace api\client;
use Yii;

class Client extends ClientBase
{
    public function __construct()
    {   $url = Yii::$app->params['ais_server'];
        parent::__construct($url);
    }

    public function getData($url, $query = [])
    {
        $response = $this->get($url, $query);
        return $response;
    }

    public function postData($url, $data)
    {
        $response = $this->post($url, $data);
        return  $response;
    }
}
