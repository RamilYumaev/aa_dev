<?php

namespace frontend\controllers\abiturient;

use backend\models\AisCg;
use dictionary\models\DictCompetitiveGroup;
use dictionary\models\Faculty;
use yii\web\Controller;

class ApplicationsController extends Controller
{
    public function actionGetBachelor()
    {
        $currentYear = Date("Y");

        $lastYear = $currentYear - 1;
        $transformYear = $lastYear . "-" . $currentYear;
        $currentFaculty = DictCompetitiveGroup::find()->allActualFacultyWithoutBranch($transformYear);


        return $this->render('get', [
            'currentFaculty' => $currentFaculty,
        ]);
    }
}