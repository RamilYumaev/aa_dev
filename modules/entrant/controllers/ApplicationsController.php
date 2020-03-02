<?php

namespace modules\entrant\controllers;

use dictionary\models\DictCompetitiveGroup;
use yii\web\Controller;

class ApplicationsController extends Controller
{
    public function actionGetBachelor()
    {
        $currentYear = Date("Y");

        $lastYear = $currentYear - 1;
        $transformYear = $lastYear . "-" . $currentYear;
        $currentFaculty = DictCompetitiveGroup::find()->allActualFacultyWithoutBranch($transformYear);


        return $this->render('get-bachelor', [
            'currentFaculty' => $currentFaculty,
        ]);
    }
}