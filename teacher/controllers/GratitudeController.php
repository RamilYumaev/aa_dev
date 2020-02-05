<?php

namespace teacher\controllers;

use olympic\forms\WebConferenceForm;
use olympic\models\WebConference;
use yii\web\Controller;


class GratitudeController extends Controller
{

    /**
     *
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

}
