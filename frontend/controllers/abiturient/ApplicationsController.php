<?php

namespace frontend\controllers\abiturient;

use backend\models\AisCg;
use dictionary\models\DictCompetitiveGroup;
use dictionary\models\Faculty;
use yii\web\Controller;

class ApplicationsController extends Controller
{
    public function actionGet()
    {
        $currentYear = Date("Y");

        $facultyArray = Faculty::getAllFacultyName();
        $lastYear = $currentYear - 1;
        $transformYear = $lastYear . " - " . $currentYear;
        $currentFaculty = DictCompetitiveGroup::find()->allActualFaculty($transformYear);
        $cg = DictCompetitiveGroup::find()->getAllCg($transformYear);


        return $this->render('get', [
            'facultyArray' => $facultyArray,
            'currentFaculty' => $currentFaculty,
            'cg' => $cg,
        ]);
    }
}