<?php

namespace common\moderation\jobs;
use common\moderation\helpers\DataExportHelper;
use modules\entrant\models\AisReturnData;
use yii\base\BaseObject;
use yii\helpers\Json;

class UpdateData extends BaseObject implements \yii\queue\JobInterface
{
    /** @var AisReturnData */
    public $model;
    public $token;

    public function execute($queue)
    {
        $data = Json::encode(DataExportHelper::dataEduction($this->model->id));
            $ch = curl_init();
            $headers = array("Content-Type" => "multipart/form-data");
            curl_setopt($ch, CURLOPT_URL, \Yii::$app->params['ais_server'] . '/import-entrant-update--new-doc?access-token=' . $this->token);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
            $result = Json::decode($result);
            $this->model->record_id_ais = $result['id'];
            $this->model->save();
    }
}