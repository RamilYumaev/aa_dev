<?php

namespace console\controllers;

use dictionary\models\DictCompetitiveGroup;
use dictionary\models\Faculty;
use modules\transfer\helpers\ConverterFaculty;
use modules\transfer\models\StatementTransfer;
use yii\console\Controller;

class TransferGenerateController extends Controller
{

    public function actionIndex()
    {
        /**
         * @var $statement StatementTransfer;
         */
        foreach (StatementTransfer::find()->all() as $statement) {
             if($statement->cg) {
                 $statement->faculty_id = ConverterFaculty::searchFaculty($statement->cg->faculty_id);
             }
             if($statement->transferMpgu->inMpgu()) {
                 $faculty = Faculty::findOne(['ais_id' => $statement->transferMpgu->getDataMpsu()['faculty_id']]);
                 $statement->faculty_id = ConverterFaculty::searchFaculty($faculty->id);
             }
             $statement->save();
        }
    }


    private function getEducationLevel($depart, $foreignerStatus)
    {
        return DictCompetitiveGroup::find()
            ->currentAutoYear()
            ->foreignerStatus($foreignerStatus)
            ->select('edu_level')
            ->departments($depart)
            ->groupBy('edu_level')
            ->tpgu(0)
            ->column();
    }

    private function getEducationForm($depart, $eduLevel, $foreignerStatus)
    {
        return DictCompetitiveGroup::find()
            ->currentAutoYear()
            ->foreignerStatus($foreignerStatus)
            ->eduLevel($eduLevel)
            ->select('education_form_id')
            ->departments($depart)
            ->groupBy('education_form_id')
            ->tpgu(0)
            ->column();

    }

    private function getDbFinanceArray($depart, $educationLevel, $eduForm, $foreignerStatus)
    {
        return DictCompetitiveGroup::find()
            ->select('financing_type_id')
            ->currentAutoYear()
            ->foreignerStatus($foreignerStatus)
            ->departments($depart)
            ->eduLevel($educationLevel)
            ->formEdu($eduForm)
            ->groupBy('financing_type_id')
            ->column();
    }

    private function getCompetitionsType($depart, $educationLevel, $eduForm, $foreignerStatus)
    {
        return DictCompetitiveGroup::find()
            ->select('special_right_id')
            ->currentAutoYear()
            ->departments($depart)
            ->foreignerStatus($foreignerStatus)
            ->eduLevel($educationLevel)
            ->formEdu($eduForm)
            ->groupBy('special_right_id')
            ->column();
    }

}