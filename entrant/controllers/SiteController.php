<?php

namespace entrant\controllers;

use dictionary\models\DictSchoolsReport;
use olympic\forms\WebConferenceForm;
use olympic\models\WebConference;
use entrant\helpers\TeacherClassUserHelper;
use entrant\models\TeacherClassUser;
use entrant\models\UserTeacherJob;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

}
