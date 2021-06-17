<?php
namespace console\controllers;

use dictionary\models\DictCompetitiveGroup;
use modules\dictionary\models\SettingEntrant;
use modules\dictionary\services\SettingEntrantService;
use modules\entrant\helpers\AnketaHelper;
use yii\console\Controller;

class SettingEntrantListController extends Controller
{
    public function __construct($id, $module, SettingEntrantService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $data = [];
        foreach (SettingEntrant::find()->andWhere(['id' => [76,182]])->all() as $settingEntrant) {
            $data[$settingEntrant->id] =$settingEntrant->isGraduate() ? count($settingEntrant->getAllGraduateCgAisId()) : count($settingEntrant->getAllCgAisId());
        }
        var_dump($data);
    }



//    public function actionIndex()
//    {
//        $finances = [DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET, DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT];
//        $foreignStatuses = [0,1];
//        $data = [];
//        foreach ($finances as $finance) {
//            foreach ($foreignStatuses as $foreignStatus) {
//                foreach (array_values(array_flip(DictFacultyHelper::facultyListSetting())) as $department) {
//                    foreach ($this->eduLevels($department, $finance, $foreignStatus) as $eduLevel) {
//                        foreach ($this->specRight($department, $finance, $foreignStatus, $eduLevel) as $spec) {
//                            foreach ($this->form($department, $finance, $foreignStatus, $eduLevel, $spec) as $form) {
//                                $data[$finance][$foreignStatus][$department][$eduLevel][$spec][$form] = $department;
//                            }
//                        }
//                    }
//                }
//            }
//        }
//        var_dump($data);
//    }

    private function faculty($department, $finance, $foreignStatus) {
        $query = DictCompetitiveGroup::find()->currentAutoYear();
        if ($department == AnketaHelper::HEAD_UNIVERSITY) {
            $query->notInFaculty();
        }else{
            $query->faculty($department);
        }
       return $query->finance($finance)->foreignerStatus($foreignStatus)->tpgu(false);
    }

    private function eduLevels($department, $finance, $foreignStatus) {
        return  $this->faculty($department, $finance, $foreignStatus)->select('edu_level')->groupBy('edu_level')->column();
    }

    private function specRight($department, $finance, $foreignStatus, $eduLevel) {
        return $this->faculty($department, $finance, $foreignStatus)->eduLevel($eduLevel)->select('special_right_id')
            ->groupBy('special_right_id')->column();
    }

    private function form($department, $finance, $foreignStatus, $eduLevel, $specRight) {
        return $this->faculty($department, $finance, $foreignStatus)->eduLevel($eduLevel)
            ->specialRight($specRight)
            ->select('education_form_id')->groupBy('education_form_id')->column();
    }
//
//    private function isOchEx($department, $eduLevel, $specRight, $finance, $formEdu) {
//        return $this->queryCg($department)->joinWith(['examinations'], false)
//            ->innerJoin(DictDiscipline::tableName(), 'discipline_competitive_group.discipline_id=dict_discipline.id')
//            ->andWhere(['is_och' => true])
//            ->eduLevel($eduLevel)
//            ->specialRight($specRight)
//            ->formEdu($formEdu)
//            ->select('special_right_id')
//            ->finance($finance)
//            ->column();
//    }
}