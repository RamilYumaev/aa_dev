<?php

namespace modules\entrant\controllers;

use dictionary\models\DictCompetitiveGroup;
use dictionary\repositories\DictCompetitiveGroupRepository;
use modules\entrant\models\UserCg;
use modules\entrant\repositories\UserCgRepository;
use yii\web\Controller;

class ApplicationsController extends Controller
{

    private $repository, $repositoryCg;

    public function __construct($id, $module, UserCgRepository $repository, DictCompetitiveGroupRepository $repositoryCg, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->repository = $repository;
        $this->repositoryCg = $repositoryCg;
    }

    public function actionGetBachelor()
    {
//        $currentYear = Date("Y");
//
//        $currentYear -= 1; //@TODO потом убрать
//
//        $lastYear = $currentYear - 1;
//        $transformYear = $lastYear . "-" . $currentYear;
//        $currentFaculty = DictCompetitiveGroup::find()->allActualFacultyWithoutBranch($transformYear);


//        return $this->render('get-bachelor', [
////            'currentFaculty' => $currentFaculty,
////            'transformYear' => $transformYear,
//        ]);

        return $this->renderList();
    }

    public function actionSaveCg($id)
    {

        try {
            $cg = $this->repositoryCg->get($id);
            $this->repository->haveARecord($cg->id);
            $userCg = UserCg::create($cg->id);
            $this->repository->save($userCg);
            if (\Yii::$app->request->isAjax) {
                return $this->renderList();
            }
            } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect("get-bachelor");

    }



    protected function renderList()
    {
        $currentYear = Date("Y");

        $currentYear -= 1; //@TODO потом убрать

        $lastYear = $currentYear - 1;
        $transformYear = $lastYear . "-" . $currentYear;
        $currentFaculty = DictCompetitiveGroup::find()->allActualFacultyWithoutBranch($transformYear);


        $method = \Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        return $this->$method('get-bachelor', [
            'currentFaculty' => $currentFaculty,
            'transformYear' => $transformYear,]);
    }


    public function actionRemoveCg($id)
    {
        try {
            $userCg = $this->repository->get($id);
            $this->repository->remove($userCg);
            if (\Yii::$app->request->isAjax) {
                return $this->renderList();
            }
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect("get-bachelor");
    }
}