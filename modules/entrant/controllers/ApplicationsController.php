<?php

namespace modules\entrant\controllers;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use dictionary\repositories\DictCompetitiveGroupRepository;
use modules\entrant\models\UserCg;
use modules\entrant\repositories\UserCgRepository;
use yii\web\Controller;

class ApplicationsController extends Controller
{

    private $repository, $repositoryCg;
    public $currentYear = 2020;

    public function __construct($id, $module, UserCgRepository $repository, DictCompetitiveGroupRepository $repositoryCg, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->repository = $repository;
        $this->repositoryCg = $repositoryCg;
    }

    public function actionGetCollege()
    {

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

        $lastYear = $this->currentYear - 1;
        $transformYear = $lastYear . "-" . $this->currentYear;
        $currentFaculty = array_unique(DictCompetitiveGroup::find()
            ->allActualFacultyWithoutBranch($transformYear)->column());


        return $this->render('get-bachelor', [
            'currentFaculty' => $currentFaculty,
            'transformYear' => $transformYear,
        ]);
    }

    public function actionGetMagistracy()
    {
        $lastYear = $this->currentYear - 1;
        $transformYear = $lastYear . "-" . $this->currentYear;
        $currentFaculty = array_unique(DictCompetitiveGroup::find()
            ->allActualFacultyWithoutBranch($transformYear)->column());


        return $this->render('get-magistracy', [
            'currentFaculty' => $currentFaculty,
            'transformYear' => $transformYear,
        ]);
    }

    public function actionGetGraduate()
    {
        $lastYear = $this->currentYear - 1;
        $transformYear = $lastYear . "-" . $this->currentYear;
        $currentFaculty = DictCompetitiveGroup::find()
            ->allActualFacultyWithoutBranch($transformYear);


        return $this->render('get-graduate', [
            'currentFaculty' => $currentFaculty,
            'transformYear' => $transformYear,
        ]);
    }

    public function actionSaveCg($id)
    {

        try {
            $cg = $this->repositoryCg->get($id);
            $this->repository->haveARecord($cg->id);
            $userCg = UserCg::create($cg->id);
            $this->repository->save($userCg);
            if (\Yii::$app->request->isAjax) {
                return $this->renderList($cg->edu_level);
            }
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect("applications/"
            . DictCompetitiveGroupHelper::getUrl($cg->edu_level));

    }

    protected function renderList($level)
    {

        $lastYear = $this->currentYear - 1;
        $transformYear = $lastYear . "-" . $this->currentYear;
        $currentFaculty = array_unique(DictCompetitiveGroup::find()
            ->allActualFacultyWithoutBranch($transformYear)->column());

        $url = DictCompetitiveGroupHelper::getUrl($level);
        $method = \Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        return $this->$method($url, [
            'currentFaculty' => $currentFaculty,
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
                return $this->renderList($cg->edu_level);
            }
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(DictCompetitiveGroupHelper::getUrl($cg->edu_level));
    }
}