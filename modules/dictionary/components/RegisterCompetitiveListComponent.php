<?php
namespace modules\dictionary\components;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\jobs\CompetitionListJob;
use modules\dictionary\models\RegisterCompetitionList;
use modules\dictionary\models\SettingCompetitionList;
use modules\dictionary\models\SettingEntrant;
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
        $date = date('Y-m-d');
        echo count(SettingCompetitionList::find()->getAllWork($date));
        foreach (SettingCompetitionList::find()->joinWith('settingEntrant')->getAllWork($date) as $item) {
            /** @var SettingEntrant $settingEntrant */
            $settingEntrant = $item->settingEntrant;
            $array = $settingEntrant->isGraduate() ? $settingEntrant->getAllGraduateCgAisId() : $settingEntrant->getAllCgAisId();
            //$array =$settingEntrant->isGraduate() ?  [['ais_id'=> [571, 573], 'faculty_id' => 1, 'speciality_id' => 4]] : [['ais_id'=> 571, 'faculty_id' => 1, 'speciality_id' => 4]];
            $this->push($array, $item, $date);
        }
    }

    public function push($array, SettingCompetitionList $item, $date){
        foreach ($array as $value) {
            $ais_id = is_array($value['ais_id']) ? implode(',',$value['ais_id']) : $value['ais_id'];
            $modelRegister = $item->getRegisterCompetitionListForDateAisType($date, $ais_id, $this->type);
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

            $register = $this->getRegisterCompositeList($item, $number, $ais_id, $value['faculty_id'], $value['speciality_id']);
            $compositeJob = new CompetitionListJob(['register' => $register]);
            if($this->queue) {
                Yii::$app->queue->push($compositeJob);
            }else {
                $compositeJob->generate();
                return $register;
            }
        }
    }

    protected function getRegisterCompositeList(SettingCompetitionList $item, $number, $value, $facultyId, $specializationId) {
        $register = new RegisterCompetitionList();
        $register->data($value, $this->type , $number ? ++$number : 1, $specializationId, $facultyId, $item->se_id);
        $register->setStatus(RegisterCompetitionList::STATUS_QUEUE);
        $register->save();
        return $register;
    }

}