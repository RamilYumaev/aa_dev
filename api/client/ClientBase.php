<?php

namespace api\client;

abstract class ClientBase
{
    public $client;

    public function __construct($baseUrl, $token = null, $secret = null)
    {
        $headers = [
            "Content-Type" => "application/json",
            "Accept" => "application/json",
        ];
        if ($secret) {
            $headers["X-Secret"] = $secret;
        }
        $this->client = new \GuzzleHttp\Client([
            "base_uri" => $baseUrl,
            "headers" => $headers,
            "timeout" => 600,
        ]);
    }

    protected function get($url, $query = [])
    {
        $response = $this->client->get($url, ["query" => $query]);
        return json_decode($response->getBody(), true);
    }

    protected function post($url, $data)
    {
        $response = $this->client->post($url, [
            "json" => $data
        ]);
        return json_decode($response->getBody(), true);
    }
}
