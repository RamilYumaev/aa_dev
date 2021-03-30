<?php

namespace modules\entrant\controllers\frontend;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\dictionary\models\SettingEntrant;
use modules\entrant\helpers\AnketaHelper;
use modules\entrant\helpers\SettingContract;
use modules\entrant\models\Anketa;
use modules\entrant\services\ApplicationsService;
use yii\web\Controller;
use Yii;

class ApplicationsDoubleController extends Controller
{
    private $service;

    public function __construct($id, $module, ApplicationsService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function actionGetCollege()
    {
        $this->isOpenEduLevel(DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO);
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO);
        $currentFaculty = $this->currentFaculty(DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO);
        return $this->render('get-college', [
            'currentFaculty' => $currentFaculty,
            'anketa'=> $this->getAnketa(),
        ]);
    }

    private function currentFaculty($eduLevel) {
        $form = SettingEntrant::find()->type(SettingEntrant::ZUK)->groupData($eduLevel, 'form_edu');
        return DictCompetitiveGroup::find()
            ->allActualFaculty($eduLevel, $form);
    }
    private function isOpenEduLevel($eduLevel){
        $isOpen = SettingEntrant::find()->type(SettingEntrant::ZUK)->eduLevelOpen($eduLevel);
        if(!$isOpen) {
            Yii::$app->session->setFlash('info', 'Прием документов окончен!');
            Yii::$app->getResponse()->redirect(['/abiturient/anketa/step2']);
            Yii::$app->end();
        }
    }

    public function actionGetBachelor()
    {

        Yii::$app->session->setFlash('info', 'Прием документов  окончен!');
        Yii::$app->getResponse()->redirect(['/abiturient/anketa/step2']);
        Yii::$app->end();

        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);

        $currentFaculty = $this->unversityChoiceForController(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);

        return $this->render('get-bachelor', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    public function actionGetTargetBachelor()
    {
        Yii::$app->session->setFlash('info', 'Прием документов  окончен!');
        Yii::$app->getResponse()->redirect(['/abiturient/anketa/step2']);
        Yii::$app->end();
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);
        $this->allowTarget(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);
        $currentFaculty = $this->unversityChoiceForController(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);

        return $this->render('get-target-bachelor', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    public function actionGetSpecialRightBachelor()
    {

        Yii::$app->session->setFlash('info', 'Прием документов  окончен!');
        Yii::$app->getResponse()->redirect(['/abiturient/anketa/step2']);
        Yii::$app->end();
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);

        $currentFaculty = $this->unversityChoiceForController(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);


        return $this->render('get-special-right-bachelor', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    public function actionGetMagistracy()
    {

        Yii::$app->session->setFlash('info', 'Прием документов  окончен!');
        Yii::$app->getResponse()->redirect(['/abiturient/anketa/step2']);
        Yii::$app->end();
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER);

        $currentFaculty = $this->unversityChoiceForController(DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER);


        return $this->render('get-magistracy', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    public function actionGetTargetMagistracy()
    {

        Yii::$app->session->setFlash('info', 'Прием документов  окончен!');
        Yii::$app->getResponse()->redirect(['/abiturient/anketa/step2']);
        Yii::$app->end();
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER);
        $this->allowTarget(DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER);


        $currentFaculty = $this->unversityChoiceForController(DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER);


        return $this->render('get-target-magistracy', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    public function actionGetGraduate()
    {

        Yii::$app->session->setFlash('info', 'Прием документов  окончен!');
        Yii::$app->getResponse()->redirect(['/abiturient/anketa/step2']);
        Yii::$app->end();
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL);

        $currentFaculty = $this->unversityChoiceForController(DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL);


        return $this->render('get-graduate', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    public function actionGetMpguTpgu()
    {
        Yii::$app->session->setFlash('info', 'Прием документов  окончен!');
        Yii::$app->getResponse()->redirect(['/abiturient/anketa/step2']);
        Yii::$app->end();
        $currentFaculty = $this->unversityChoiceForController(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);
        return $this->render('get-mpgu-tpgu', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    public function actionGetTargetGraduate()
    {
        Yii::$app->session->setFlash('info', 'Прием документов  окончен!');
        Yii::$app->getResponse()->redirect(['/abiturient/anketa/step2']);
        Yii::$app->end();
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL);
        $this->allowTarget(DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL);

        $currentFaculty = $this->unversityChoiceForController(DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL);


        return $this->render('get-target-graduate', [
            'currentFaculty' => $currentFaculty,
        ]);
    }

    public function actionGetGovLineBachelor()
    {
        Yii::$app->session->setFlash('info', 'Прием документов  окончен!');
        Yii::$app->getResponse()->redirect(['/abiturient/anketa/step2']);
        Yii::$app->end();
        $this->permittedLevelChecked(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);
        $this->isGovLineControl();
        $currentFaculty = $this->unversityChoiceForController(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);

        return $this->render('get-gov-line-bachelor', [
            'currentFaculty' => $currentFaculty,
        ]);

    }

    public function actionGetGovLineMagistracy()
    {
        Yii::$app->session->setFlash('info', 'Прием документов  окончен!');
        Yii::$app->getResponse()->redirect(['/abiturient/anketa/step2']);
        Yii::$app->end();
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
        Yii::$app->session->setFlash('info', 'Прием документов  окончен!');
        Yii::$app->getResponse()->redirect(['/abiturient/anketa/step2']);
        Yii::$app->end();
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
            if(!SettingContract::isJob($cg))
            {
                throw new \DomainException("Прием документов на данную образовательную программу окончен!");
            }
            $this->service->saveCg($cg, $cathedra_id, $this->anketa);
            if (\Yii::$app->request->isAjax) {
                return $this->renderList($cg->edu_level, $cg->special_right_id, $cg->isGovLineCg(), $cg->tpgu_status);
            }
            return $this->redirect("/abiturient/applications/"
                    . DictCompetitiveGroupHelper::getUrl($cg->edu_level, $cg->special_right_id, $cg->isGovLineCg(), $cg->tpgu_status));
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    protected function renderList($level, $specialRight, $govLineStatus, $tpguStatus)
    {

        $currentFacultyBase = $this->universityChoiceBase($level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO ||
            $level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL
            ? true : false);

        if ($specialRight == DictCompetitiveGroupHelper::SPECIAL_RIGHT) {
            $currentFaculty = $currentFacultyBase->onlySpecialRight()->column();
        } elseif ($specialRight == DictCompetitiveGroupHelper::TARGET_PLACE) {
            $currentFaculty = $currentFacultyBase->onlyTarget()->column();
        } else if ($govLineStatus) {
            $currentFaculty = $currentFacultyBase->getGovLineCg()->column();
        } else if($tpguStatus){
            $currentFaculty = $currentFacultyBase->onlyTpgu()->column();
        }else {
            $currentFaculty = $currentFacultyBase->column();
        }
        $url = DictCompetitiveGroupHelper::getUrl($level, $specialRight, $govLineStatus, $tpguStatus);
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
                return $this->renderList($cg->edu_level, $cg->special_right_id, $cg->isGovLineCg(), $cg->tpgu_status);
            }
            return $this->redirect(DictCompetitiveGroupHelper::getUrl($cg->edu_level, $cg->special_right_id, $cg->isGovLineCg(), $cg->tpgu_status));
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

    private function universityChoiceBase($spo = false)
    {
        if ($this->anketa->university_choice == AnketaHelper::HEAD_UNIVERSITY) {
            $model = DictCompetitiveGroup::find()
                ->allActualFacultyWithoutBranch($spo);
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
                ->allActualFacultyWithoutBranch($eduLevel == DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO ? true : false)->eduLevel($eduLevel)->column());
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