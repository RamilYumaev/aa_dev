<?php


namespace modules\dictionary\jobs;
use api\client\Client;
use dictionary\helpers\CathedraCgHelper;
use GuzzleHttp\Exception\ClientException;
use modules\dictionary\models\CompetitionList;
use modules\dictionary\models\RegisterCompetitionList;
use Yii;
use yii\base\BaseObject;
use yii\helpers\FileHelper;

class CompetitionListJob extends BaseObject implements \yii\queue\JobInterface
{
    private $url ='external/incoming-abiturient/get-list';

    /** @var RegisterCompetitionList $register */

    public $register;

    /**
     * @param \yii\queue\Queue $queue
     * @return mixed|void
     * @throws \yii\base\Exception
     */

    public function execute($queue)
    {
        $this->generate();
    }

    public function generate()
    {
        $this->saveRegister(RegisterCompetitionList::STATUS_SEND);
        $array['competitive_group_id'] = $this->register->ais_cg_id;
        $array['token'] = \md5($this->register->ais_cg_id . \date('Y.m.d').Yii::$app->params['keyAisCompetitiveList']);
        if($this->register->settingCompetitionList->isEndDateZuk()) {
            $array['status']=1;
        }
        try {
            $item = (new Client(Yii::$app->params['ais_competitive']))->getData($this->url, $array);
            $this->saveCompetitionList($item, 'list', 'list_bvi');
            if($this->register->settingEntrant->isBachelor()) {
                if (key_exists('list_bvi', $item) && count($item['list_bvi']) ) {
                    $this->saveCompetitionList($item, 'list_bvi', 'list');
                }
            }
        if (key_exists('error', $item)) {
            $this->saveRegister(RegisterCompetitionList::STATUS_ERROR, $item['error']['message']);
        }
        }catch (ClientException $exception)  {
            $this->saveRegister(RegisterCompetitionList::STATUS_ERROR, $exception->getMessage());
        }

    }

    public function saveCompetitionList($item, $key, $keyUnset)
    {
        if (key_exists($key, $item)) {
            $model = new CompetitionList();
            if (key_exists($keyUnset, $item)) {
                unset($item[$keyUnset]);
            }
            if(count($item[$key])) {
                $dateObject = new \DateTime($item['date_time']);
                $ymd = $dateObject->format("Ymd");
                $path = '/entrant/files/' . $ymd . '/' . $this->register->typeName .
                    $this->register->number_update . '/' .
                    $this->register->settingEntrant->edu_level . '/' .
                    (is_null($this->register->settingEntrant->special_right) ? 0 : $this->register->settingEntrant->special_right);
                $alias = \Yii::getAlias('@modules');
                $fileName = ($this->register->settingEntrant->isGraduate() ? $this->register->faculty_id . '_' . $this->register->speciality_id : $this->register->ais_cg_id) . "_" . $key . '.json';
                if(!FileHelper::createDirectory($alias . $path)) {
                    throw  new \DomainException("Не удалось создать папку ". $alias . $path);
                }
                file_put_contents($alias . $path . '/' . $fileName, json_encode($item));
                $model->data($this->register->id, $key, $item['date_time'], $path . '/' . $fileName);
                $model->save();
                $this->saveRegister(RegisterCompetitionList::STATUS_SUCCESS);
            } else {
                $this->saveRegister(RegisterCompetitionList::STATUS_NOT);
            }
        }
    }

    protected function saveRegister($status, $message = '')
    {
        $this->register->setStatus($status);
        $this->register->setErrorMessage($message);
        $this->register->save();
    }
}