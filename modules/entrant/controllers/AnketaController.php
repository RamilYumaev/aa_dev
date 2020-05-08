<?php

namespace modules\entrant\controllers;


use modules\entrant\forms\AnketaForm;
use modules\entrant\helpers\AnketaHelper;
use modules\entrant\helpers\CategoryStruct;
use modules\entrant\models\Anketa;
use modules\entrant\services\AnketaService;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;


class AnketaController extends Controller
{

    private $service;
    private $anketa;


    public function __construct($id, $module, AnketaService $service, $config = [])
    {
        $this->service = $service;
        $this->anketa = $this->findModelByUser();
        parent::__construct($id, $module, $config);
    }

    public function actionStep1()
    {
        if ($this->anketa) {
            Yii::$app->session->setFlash("warning", "Редактирование анкеты приведет к удалению всех ранее 
        выбранных образовательных программ и введенных результатов ЕГЭ!");
            $form = new AnketaForm($this->anketa);
        } else {
            $form = new AnketaForm();
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                if ($this->anketa) {
                    $model = $this->service->update($this->anketa->id, $form);
                } else {
                    $model =  $this->service->create($form);
                }
                if ($model->category_id == CategoryStruct::SPECIAL_RIGHT_COMPETITION) {
                    return $this->redirect(["other-document/exemption"]);
                } elseif($model->category_id == CategoryStruct::COMPATRIOT_COMPETITION) {
                    return $this->redirect(["other-document/patriot"]);
                } elseif($model->category_id == CategoryStruct::TARGET_COMPETITION) {
                    return $this->redirect(["agreement/index"]);
                } else {
                    return $this->redirect(["step2"]);
                }
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        if ($this->anketa) {
            return $this->render('update', [
                'model' => $form,
            ]);
        } else {
            return $this->render('create', [
                'model' => $form,
            ]);
        }
    }

    public function actionStep2()
    {

        if ($this->anketa === null) {
            return $this->redirect(['step1']);
        }


        return $this->render("step2", ['anketa' => $this->anketa]);


    }

    public function actionChoiceEducationLevel()
    {

        $anketa = $this->findModelByUser();
        if (!$anketa) {
            $this->redirect("index");
        }
    }


    public function actionGetCategory($foreignerStatus, $educationLevel, $universityChoice)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
       // return ['result' => $this->service->category($foreignerStatus)];

        return ['result'=> CategoryStruct::datasetQualifier($foreignerStatus, $educationLevel, $universityChoice)];
    }

    public function actionGetAllowEducationLevelByBranch($universityId)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return ['result'=> AnketaHelper::educationLevelChoice($universityId)];

    }


    /**
     * @param $id
     * @return Anketa
     * @throws NotFoundHttpException
     */
    protected function findModel($id): Anketa
    {
        if (($model = Anketa::findOne(['id' => $id, 'user_id' => Yii::$app->user->identity->getId()])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }

    protected function findModelByUser()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('default/index');
        }
        return Anketa::findOne(['user_id' => Yii::$app->user->identity->getId()]);

    }
}