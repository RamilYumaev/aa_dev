<?php


namespace modules\entrant\jobs;
use api\client\Client;
use GuzzleHttp\Exception\ClientException;
use modules\entrant\helpers\DataExportHelper;
use modules\entrant\helpers\DateFormatHelper;
use modules\entrant\services\UserDisciplineService;
use yii\base\BaseObject;
use yii\helpers\FileHelper;

class CseAsyncJob extends BaseObject implements \yii\queue\JobInterface
{

    /* @var \olympic\models\auth\Profiles $profile */

    public $profile;

    private $url = '/incoming_2021/fok/sdo/vi-synchronization';

    /**
     * @param \yii\queue\Queue $queue
     * @return mixed|void
     * @throws \yii\base\Exception
     */
    public function execute($queue)
    {
        $token = 'fIjpVspL9DmR5cpgzwWHd91nR19ttv4z';
        $url = $this->url.'?incomingId='.$this->profile->aisUser->incoming_id.'&access-token=' . $token;
        $data = DataExportHelper::cseVi($this->profile->user_id);
        try {
            $item = (new Client())->postData($url, $data);
            $this->pathFile($item, $this->profile->aisUser->incoming_id);
        } catch (ClientException $exception) {
            $this->pathFile($exception->getMessage(), $this->profile->aisUser->incoming_id);
        }
    }

    /**
     * @param $item
     * @param $incomingId
     * @throws \yii\base\Exception
     */
    public function pathFile($item, $incomingId) {
        $dateObject = new \DateTime();
        $ymd = $dateObject->format("Ymd");
        $path = '/entrant/result';
        $alias = \Yii::getAlias('@modules');
        $fileName = 'result.txt';
        if(!FileHelper::createDirectory($alias . $path)) {
            throw  new \DomainException("Не удалось создать папку ". $alias . $path);
        }
        file_put_contents($alias . $path . '/' . $fileName, $incomingId.' '.(is_array($item) ? $item['message'] :  $item), FILE_APPEND);
    }
}