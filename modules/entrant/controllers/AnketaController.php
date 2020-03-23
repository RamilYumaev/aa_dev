<?php

namespace modules\entrant\controllers;


use modules\dictionary\models\DictCategory;
use modules\entrant\forms\AnketaForm;
use modules\entrant\helpers\AnketaHelper;
use modules\entrant\models\Anketa;
use modules\entrant\repositories\AnketaRepository;
use modules\entrant\services\AnketaService;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;


class AnketaController extends Controller
{

    private $service;


    public function __construct($id, $module, AnketaService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $model = $this->findModelByUser();

        if ($model) {
            Yii::$app->session->setFlash("warning", "Редактирование анкеты приведет к удалению всех ранее 
        выбранных образовательных программ!");
            $form = new AnketaForm($model);
        } else {
            $form = new AnketaForm();

        }

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                if ($model) {
                    $this->service->update($model->id, $form);

                } else {
                    $this->service->create($form);

                }
                return $this->redirect(["default/index"]); //@TODO
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        if ($model) {
            return $this->render('update', [
                'model' => $form,
            ]);
        } else {
            return $this->render('create', [
                'model' => $form,
            ]);
        }
    }

    public function actionChoiceEducationLevel()
    {

        $anketa = $this->findModelByUser();
        if(!$anketa)
        {
            $this->redirect("index");
        }
    }


    public function actionGetCategory($foreignerStatus)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['result' => $this->service->category($foreignerStatus)];
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
        return Anketa::findOne(['user_id' => Yii::$app->user->identity->getId()]);

    }
}