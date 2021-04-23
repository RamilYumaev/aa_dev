<?php
namespace modules\dictionary\components;

use modules\dictionary\jobs\CompetitionListJob;
use modules\dictionary\models\RegisterCompetitionList;
use modules\dictionary\models\SettingCompetitionList;
use Yii;

class RegisterCompetitiveListComponent
{
    private $type;
    private $queue;

    public function __construct($type, $queue = true)
    {
        $this->type = $type;
        $this->queue = $queue;
    }

    public function handle() {
        /** @var SettingCompetitionList $item */
        $date = '2021-04-25';
        echo count(SettingCompetitionList::find()->getAllWork($date));
        foreach (SettingCompetitionList::find()->getAllWork($date) as $item) {
            $settingEntrant = $item->settingEntrant;
            $array = $settingEntrant->getAllCgAisId();
            $array = [571];
            $this->push($array, $item, $date);
        }
    }

    public function push($array, SettingCompetitionList $item, $date){
        foreach ($array as $value) {
            $modelRegister = $item->getRegisterCompetitionListForDateAisType($date, $value, $this->type);
            $number = $modelRegister->max('number_update');
            $timeLast = $modelRegister->select('time')->orderBy(['number_update' => SORT_DESC])->one();

            if($timeLast && $this->type == RegisterCompetitionList::TYPE_AUTO) {
                $time = strtotime(date('H:i:s'));
                $last = strtotime($timeLast->time);
                $result = $time - $last;
                if($result <= $item->getIntTimeWork($date)) {
                    continue;
                }
            }

            $register = $this->getRegisterCompositeList($item, $number, $value);
            $compositeJob = new CompetitionListJob(['url' => '', 'register' => $register]);
            if($this->queue) {
                Yii::$app->queue->push($compositeJob);
            }else {
                $compositeJob->generate();
                return $register;
            }
        }
    }

    protected function getRegisterCompositeList(SettingCompetitionList $item, $number, $value) {
        $register = new RegisterCompetitionList();
        $register->data($value, $this->type , $number ? ++$number : 1,  $item->se_id);
        $register->setStatus(RegisterCompetitionList::STATUS_QUEUE);
        $register->save();
        return $register;
    }

}