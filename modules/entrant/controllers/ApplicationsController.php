<?php

namespace modules\entrant\controllers;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use dictionary\repositories\DictCompetitiveGroupRepository;
use modules\entrant\helpers\AnketaHelper;
use modules\entrant\models\Anketa;
use yii\helpers\Url;
use modules\entrant\models\UserCg;
use modules\entrant\repositories\UserCgRepository;
use yii\web\Controller;
use Yii;

class ApplicationsController extends Controller
{

    private $repository, $repositoryCg;
    private $anketa;

    public function __construct($id, $module,
                                UserCgRepository $repository,
                                DictCompetitiveGroupRepository $repositoryCg, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->repository = $repository;
        $this->repositoryCg = $repositoryCg;
        $this->anketa = $this->findModelByUser();
    }

    public function actionGetCollege()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO);
        $currentFaculty = $this->unversityChoiceForController();

        return $this->render('get-college', [
            'currentFaculty' => $currentFaculty,

        ]);
    }

    public function actionGetBachelor()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);

        $currentFaculty = $this->unversityChoiceForController();

        return $this->render('get-bachelor', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    public function actionGetTargetBachelor()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);
        $currentFaculty = $this->unversityChoiceForController();

        return $this->render('get-target-bachelor', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    public function actionGetSpecialRightBachelor()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);

        $currentFaculty = $this->unversityChoiceForController();


        return $this->render('get-special-right-bachelor', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    public function actionGetMagistracy()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER);

        $currentFaculty = $this->unversityChoiceForController();


        return $this->render('get-magistracy', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    public function actionGetTargetMagistracy()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER);

        $currentFaculty = $this->unversityChoiceForController();


        return $this->render('get-target-magistracy', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    public function actionGetGraduate()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL);

        $currentFaculty = $this->unversityChoiceForController();


        return $this->render('get-graduate', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    public function actionGetTargetGraduate()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL);

        $currentFaculty = $this->unversityChoiceForController();


        return $this->render('get-target-graduate', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    public function actionGetGovLineBachelor()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);
        $this->isGovLineControl();
        $currentFaculty = $this->unversityChoiceForController();

        return $this->render('get-gov-line-bachelor', [
            'currentFaculty' => $currentFaculty,
        ]);

    }

    public function actionGetGovLineMagistracy()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER);
        $this->isGovLineControl();
        $currentFaculty = $this->unversityChoiceForController();
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
        $currentFaculty = $this->unversityChoiceForController();
        $educationLevel = DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL;

        return $this->render('get-gov-line-graduate', [
            'currentFaculty' => $currentFaculty,
            'educationLevel' => $educationLevel,
        ]);

    }

    public function actionSaveCg($id)
    {
        try {
            $cg = $this->repositoryCg->get($id);
            DictCompetitiveGroupHelper::oneProgramGovLineChecker($cg);
            DictCompetitiveGroupHelper::noMore3Specialty($cg);
            DictCompetitiveGroupHelper::isAvailableCg($cg);
            DictCompetitiveGroupHelper::budgetChecker($cg);
            $this->repository->haveARecord($cg->id);
            $userCg = UserCg::create($cg->id);
            $this->repository->save($userCg);
            if (\Yii::$app->request->isAjax) {
                return $this->renderList($cg->edu_level, $cg->special_right_id, $cg->isGovLineCg());
            }
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect("/abiturient/applications/"
            . DictCompetitiveGroupHelper::getUrl($cg->edu_level, $cg->special_right_id, $cg->isGovLineCg()));

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
            $userCg = $this->repository->get($id);
            $cg = $this->repositoryCg->get($id);
            $this->repository->remove($userCg);
            if (\Yii::$app->request->isAjax) {
                return $this->renderList($cg->edu_level, $cg->special_right_id, $cg->isGovLineCg());
            }
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(DictCompetitiveGroupHelper::getUrl($cg->edu_level, $cg->special_right_id, $cg->isGovLineCg()));
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

    private function unversityChoiceForController()
    {
        if ($this->anketa->university_choice == AnketaHelper::HEAD_UNIVERSITY) {
            $currentFaculty = array_unique(DictCompetitiveGroup::find()
                ->allActualFacultyWithoutBranch()->column());
        } else {
            $currentFaculty = array_unique(DictCompetitiveGroup::find()
                ->branch($this->anketa->university_choice)->column());
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

    protected function findModelByUser()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('default/index');
        }
        return Anketa::findOne(['user_id' => Yii::$app->user->identity->getId()]);

    }


}