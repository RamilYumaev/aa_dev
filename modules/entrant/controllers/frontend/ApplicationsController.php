<?php

namespace modules\entrant\controllers\frontend;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use dictionary\repositories\DictCompetitiveGroupRepository;
use modules\entrant\helpers\AnketaHelper;
use modules\entrant\models\Anketa;
use modules\entrant\repositories\StatementCgRepository;
use modules\entrant\services\ApplicationsService;
use yii\helpers\Url;
use modules\entrant\models\UserCg;
use modules\entrant\repositories\UserCgRepository;
use yii\web\Controller;
use Yii;

class ApplicationsController extends Controller
{

    private $anketa;
    private $service;

    public function __construct($id, $module, ApplicationsService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
        $this->anketa = $this->getAnketa();
    }

    public function actionGetCollege()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO);
        $currentFaculty = $this->unversityChoiceForController(DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO);
        $anketa = $this->getAnketa();

        return $this->render('get-college', [
            'currentFaculty' => $currentFaculty,
            'anketa'=> $anketa,

        ]);
    }

    public function actionGetBachelor()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);

        $currentFaculty = $this->unversityChoiceForController(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);

        return $this->render('get-bachelor', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    public function actionGetTargetBachelor()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);
        $this->allowTarget(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);
        $currentFaculty = $this->unversityChoiceForController(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);

        return $this->render('get-target-bachelor', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    public function actionGetSpecialRightBachelor()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);

        $currentFaculty = $this->unversityChoiceForController(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);


        return $this->render('get-special-right-bachelor', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    public function actionGetMagistracy()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER);

        $currentFaculty = $this->unversityChoiceForController(DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER);


        return $this->render('get-magistracy', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    public function actionGetTargetMagistracy()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER);
        $this->allowTarget(DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER);


        $currentFaculty = $this->unversityChoiceForController(DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER);


        return $this->render('get-target-magistracy', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    public function actionGetGraduate()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL);

        $currentFaculty = $this->unversityChoiceForController(DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL);


        return $this->render('get-graduate', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    public function actionGetTargetGraduate()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL);
        $this->allowTarget(DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL);

        $currentFaculty = $this->unversityChoiceForController(DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL);


        return $this->render('get-target-graduate', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    public function actionGetGovLineBachelor()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);
        $this->isGovLineControl();
        $currentFaculty = $this->unversityChoiceForController(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);

        return $this->render('get-gov-line-bachelor', [
            'currentFaculty' => $currentFaculty,
        ]);

    }

    public function actionGetGovLineMagistracy()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER);
        $this->isGovLineControl();
        $currentFaculty = $this->unversityChoiceForController(DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER);
        $educationLevel = DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER;

        return $this->render('get-gov-line-magistracy', [
            'currentFaculty' => $currentFaculty,
            'educationLevel' => $educationLevel,
        ]);

    }

    public function actionGetGovLineGraduate()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL);
        $this->isGovLineControl();
        $currentFaculty = $this->unversityChoiceForController(DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL);
        $educationLevel = DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL;

        return $this->render('get-gov-line-graduate', [
            'currentFaculty' => $currentFaculty,
            'educationLevel' => $educationLevel,
        ]);

    }

    public function actionSaveCg($id, $cathedra_id = null)
    {

        try {
            $cg = $this->service->repositoryCg->get($id);
            if(!(\Yii::$app->user->identity->setting())->allowCgForSave($cg))
            {
                throw new \DomainException("Прием документов на данную образовательную программу окончен!");
            }
            $this->service->saveCg($cg, $cathedra_id, $this->anketa);
            if (\Yii::$app->request->isAjax) {
                return $this->renderList($cg->edu_level, $cg->special_right_id, $cg->isGovLineCg());
            }
            return $this->redirect("/abiturient/applications/"
                    . DictCompetitiveGroupHelper::getUrl($cg->edu_level, $cg->special_right_id, $cg->isGovLineCg()));
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    protected function renderList($level, $specialRight, $govLineStatus)
    {

        $currentFacultyBase = $this->universityChoiceBase();

        if ($specialRight == DictCompetitiveGroupHelper::SPECIAL_RIGHT) {
            $currentFaculty = $currentFacultyBase->onlySpecialRight()->column();
        } elseif ($specialRight == DictCompetitiveGroupHelper::TARGET_PLACE) {
            $currentFaculty = $currentFacultyBase->onlyTarget()->column();
        } else if ($govLineStatus) {
            $currentFaculty = $currentFacultyBase->getGovLineCg()->column();
        } else {
            $currentFaculty = $currentFacultyBase->column();
        }
        $url = DictCompetitiveGroupHelper::getUrl($level, $specialRight, $govLineStatus);
        $method = \Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        return $this->$method($url, [
            'currentFaculty' => array_unique($currentFaculty),
        ]);
    }

    public function actionRemoveCg($id)
    {
        try {
            $cg = $this->service->repositoryCg->get($id);
            $this->service->removeCg($cg);
            if (\Yii::$app->request->isAjax) {
                return $this->renderList($cg->edu_level, $cg->special_right_id, $cg->isGovLineCg());
            }
            return $this->redirect(DictCompetitiveGroupHelper::getUrl($cg->edu_level, $cg->special_right_id, $cg->isGovLineCg()));
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    private function permittedLevelChecked($level)
    {
        if (!in_array($level, $this->anketa->getPermittedEducationLevels())) {
            Yii::$app->session->setFlash("error", "Уровень образования недоступен!");
            Yii::$app->getResponse()->redirect(['/abiturient/anketa/step2']);
            Yii::$app->end();
        }

    }

    private function universityChoiceBase()
    {
        if ($this->anketa->university_choice == AnketaHelper::HEAD_UNIVERSITY) {
            $model = DictCompetitiveGroup::find()
                ->allActualFacultyWithoutBranch();
        } else {
            $model = DictCompetitiveGroup::find()
                ->branch($this->anketa->university_choice);
        }

        return $model;

    }

    private function unversityChoiceForController($eduLevel)
    {
        if ($this->anketa->university_choice == AnketaHelper::HEAD_UNIVERSITY) {
            $currentFaculty = array_unique(DictCompetitiveGroup::find()
                ->allActualFacultyWithoutBranch()->eduLevel($eduLevel)->column());
        } else {
            $currentFaculty = array_unique(DictCompetitiveGroup::find()
                ->branch($this->anketa->university_choice)->eduLevel($eduLevel)->column());
        }
        return $currentFaculty;

    }

    private function isGovLineControl()
    {

        if(!$this->anketa->isGovLineIncoming())
        {
            Yii::$app->session
                ->setFlash("error", "Ваши анкетные данные не соответствуют данным образовательным программам");
            Yii::$app->getResponse()->redirect(['/abiturient/anketa/step1']);
            Yii::$app->end();
        }
    }

    protected function getAnketa()
    {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect('default/index');
        }
        return \Yii::$app->user->identity->anketa();
    }

    private function allowTarget($level)
    {
        $anketa = $this->getAnketa();
        $arg1 = $anketa->onlyContract($level);
        $arg2 = $anketa->allowTarget();
        if($anketa->onlyContract($level) && $anketa->allowTarget()){
            Yii::$app->session->setFlash("error", "Целевые программы данного уровня недоступны!");
            Yii::$app->getResponse()->redirect(['/abiturient/anketa/step2']);
            Yii::$app->end();
        };
    }

    protected function findModelByUser()
    {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect('default/index');
        }
        return Anketa::findOne(['user_id' => Yii::$app->user->identity->getId()]);
    }
}