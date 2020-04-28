<?php

namespace modules\entrant\controllers;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use dictionary\repositories\DictCompetitiveGroupRepository;
use yii\helpers\Url;
use modules\entrant\models\UserCg;
use modules\entrant\repositories\UserCgRepository;
use yii\web\Controller;
use Yii;

class ApplicationsController extends Controller
{

    private $repository, $repositoryCg;
    public $currentYear = 2020;

    public function __construct($id, $module,
                                UserCgRepository $repository,
                                DictCompetitiveGroupRepository
                                $repositoryCg, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->repository = $repository;
        $this->repositoryCg = $repositoryCg;
    }

    public function actionGetCollege()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO);
        $lastYear = $this->currentYear - 1;
        $transformYear = $lastYear . "-" . $this->currentYear;
        $currentFaculty = array_unique(DictCompetitiveGroup::find()
            ->allActualFacultyWithoutBranch($transformYear)->column());


        return $this->render('get-college', [
            'currentFaculty' => $currentFaculty,
            'transformYear' => $transformYear,
        ]);
    }

    public function actionGetBachelor()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);
        $lastYear = $this->currentYear - 1;
        $transformYear = $lastYear . "-" . $this->currentYear;
        $currentFaculty = array_unique(DictCompetitiveGroup::find()
            ->allActualFacultyWithoutBranch($transformYear)->column());


        return $this->render('get-bachelor', [
            'currentFaculty' => $currentFaculty,
            'transformYear' => $transformYear,
        ]);
    }

    public function actionGetTargetBachelor()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);
        $lastYear = $this->currentYear - 1;
        $transformYear = $lastYear . "-" . $this->currentYear;
        $currentFaculty = array_unique(DictCompetitiveGroup::find()
            ->allActualFacultyWithoutBranch($transformYear)->onlyTarget()->column());


        return $this->render('get-target-bachelor', [
            'currentFaculty' => $currentFaculty,
            'transformYear' => $transformYear,
        ]);
    }

    public function actionGetSpecialRightBachelor()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);
        $lastYear = $this->currentYear - 1;
        $transformYear = $lastYear . "-" . $this->currentYear;
        $currentFaculty = array_unique(DictCompetitiveGroup::find()
            ->allActualFacultyWithoutBranch($transformYear)
            ->onlySpecialRight()
            ->column());


        return $this->render('get-special-right-bachelor', [
            'currentFaculty' => $currentFaculty,
            'transformYear' => $transformYear,
        ]);
    }

    public function actionGetMagistracy()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER);
        $lastYear = $this->currentYear - 1;
        $transformYear = $lastYear . "-" . $this->currentYear;
        $currentFaculty = array_unique(DictCompetitiveGroup::find()
            ->allActualFacultyWithoutBranch($transformYear)->column());


        return $this->render('get-magistracy', [
            'currentFaculty' => $currentFaculty,
            'transformYear' => $transformYear,
        ]);
    }

    public function actionGetTargetMagistracy()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER);
        $lastYear = $this->currentYear - 1;
        $transformYear = $lastYear . "-" . $this->currentYear;
        $currentFaculty = array_unique(DictCompetitiveGroup::find()
            ->allActualFacultyWithoutBranch($transformYear)
            ->onlyTarget()
            ->column());


        return $this->render('get-target-magistracy', [
            'currentFaculty' => $currentFaculty,
            'transformYear' => $transformYear,
        ]);
    }

    public function actionGetGraduate()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL);
        $lastYear = $this->currentYear - 1;
        $transformYear = $lastYear . "-" . $this->currentYear;
        $currentFaculty = DictCompetitiveGroup::find()
            ->allActualFacultyWithoutBranch($transformYear);


        return $this->render('get-graduate', [
            'currentFaculty' => $currentFaculty,
            'transformYear' => $transformYear,
        ]);
    }

    public function actionGetTargetGraduate()
    {
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL);
        $lastYear = $this->currentYear - 1;
        $transformYear = $lastYear . "-" . $this->currentYear;
        $currentFaculty = DictCompetitiveGroup::find()
            ->onlyTarget()
            ->allActualFacultyWithoutBranch($transformYear);


        return $this->render('get-target-graduate', [
            'currentFaculty' => $currentFaculty,
            'transformYear' => $transformYear,
        ]);
    }

    public function actionSaveCg($id)
    {

        try {
            $cg = $this->repositoryCg->get($id);
            DictCompetitiveGroupHelper::noMore3Specialty($cg);
            DictCompetitiveGroupHelper::saveChecked($id, $cg->edu_level);
            DictCompetitiveGroupHelper::budgetChecker($cg->edu_level);
            $this->repository->haveARecord($cg->id);
            $userCg = UserCg::create($cg->id);
            $this->repository->save($userCg);
            if (\Yii::$app->request->isAjax) {
                return $this->renderList($cg->edu_level, $cg->special_right_id);
            }
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect("/abiturient/applications/"
            . DictCompetitiveGroupHelper::getUrl($cg->edu_level));

    }

    protected function renderList($level, $specialRight = null)
    {

        $lastYear = $this->currentYear - 1;
        $transformYear = $lastYear . "-" . $this->currentYear;


        $currentFacultyBase = DictCompetitiveGroup::find()
            ->allActualFacultyWithoutBranch($transformYear);

        if ($specialRight == DictCompetitiveGroupHelper::SPECIAL_RIGHT) {
            $currentFaculty = $currentFacultyBase->onlySpecialRight()->column();
        } elseif ($specialRight == DictCompetitiveGroupHelper::TARGET_PLACE) {
            $currentFaculty = $currentFacultyBase->onlyTarget()->column();
        } else {
            $currentFaculty = $currentFacultyBase->column();
        }

        $url = DictCompetitiveGroupHelper::getUrl($level, $specialRight);
        $method = \Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        return $this->$method($url, [
            'currentFaculty' => array_unique($currentFaculty),
            'transformYear' => $transformYear
        ]);
    }

    public function actionRemoveCg($id)
    {
        try {
            $userCg = $this->repository->get($id);
            $cg = $this->repositoryCg->get($id);
            $this->repository->remove($userCg);
            if (\Yii::$app->request->isAjax) {
                return $this->renderList($cg->edu_level, $cg->special_right_id);
            }
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(DictCompetitiveGroupHelper::getUrl($cg->edu_level));
    }

    private function permittedLevelChecked($level)
    {
        $anketa = \Yii::$app->user->identity->anketa();
        if (!in_array($level, $anketa->getPermittedEducationLevels())) {
            Yii::$app->session->setFlash("error", "Уровень образования недоступен!");
            Yii::$app->getResponse()->redirect(['/abiturient/anketa/step2']);
            Yii::$app->end();
        }

    }


}