<?php


namespace modules\entrant\controllers\frontend;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\behaviors\AnketaRedirectBehavior;
use modules\entrant\forms\CseSubjectMarkForm;
use modules\entrant\forms\CseSubjectResultForm;
use modules\entrant\forms\ExaminationOrCseForm;
use modules\entrant\forms\UserDisciplineCseForm;
use modules\entrant\helpers\CseSubjectHelper;
use modules\entrant\helpers\UserDisciplineHelper;
use modules\entrant\models\Anketa;
use modules\entrant\models\CseSubjectResult;
use modules\entrant\models\UserDiscipline;
use modules\entrant\services\CseSubjectResultService;
use modules\entrant\services\UserDisciplineService;
use modules\exam\widgets\exam\gird\ViewAnswerAttemptTestColumn;
use yii\base\Model;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class UserDisciplineController extends Controller
{
    private $service;

    public function __construct($id, $module, UserDisciplineService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
           [
            'class'=> AnketaRedirectBehavior::class,
            'ids'=>['update','delete']]
        ];
    }

    /**
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $query  = UserDiscipline::find()->user($this->getUserId());
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'isBelarus' => $this->getAnketa()->isBelarus(),
        ]);
    }

    public function actionCreateCt()
    {
        if(!$this->getAnketa()->isBelarus()) {
            $this->redirect('index');
        }
        $config = ['user_id' => $this->getUserId(), 'type'=>UserDiscipline::CT];
        $form = new UserDisciplineCseForm(null, $config);
        return $this->formCreate($form, 'create-ct');
    }

    public function actionCreateCse()
    {
        $config = ['user_id' => $this->getUserId(), 'type'=>UserDiscipline::CSE];
        $form = new UserDisciplineCseForm(null, $config);
        return $this->formCreate($form, 'create-cse');
    }

    protected function formCreate(UserDisciplineCseForm $form, $pathView) {
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render($pathView, [
            'model' => $form,
        ]);
    }

//    public function actionCreateSelect() {
//        $config = ['user_id' => $this->getUserId()];
//        $exams = DictCompetitiveGroupHelper::groupByExams($this->getUserId());
//        $models = [];
//        foreach($exams as $key => $exam) {
//            $models[] = new UserDisciplineCseForm($this->modelDiscipline($key), $config);
//        }
//        if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
//            try {
//                $this->service->createMore($models);
//                return $this->redirect('/abiturient/default');
//            } catch (\DomainException $e) {
//                Yii::$app->errorHandler->logException($e);
//                Yii::$app->session->setFlash('error', $e->getMessage());
//            }
//        }
//        return $this->render('cse-vi-ct', [
//            'models' => $models,
//            'exams' => $exams,
//            'isBelarus' => $this->getAnketa()->isBelarus(),
//        ]);
//    }

    public function actionCorrection($discipline, $spo = null) {
        $config = ['user_id' => $this->getUserId()];
        $exams = DictCompetitiveGroupHelper::groupByExams($this->getUserId());
        if(!key_exists($discipline, $exams)) {
            return $this->redirect('/abiturient/default');
        }
        $form = new UserDisciplineCseForm($this->modelDiscipline($discipline), $config);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->createOne($form);
                if($spo) {
                    return $this->redirect(['correction-spo', 'discipline' => $spo]);
                }
                return $this->redirect('/abiturient/default');
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('_form-cse-vi-ct', [
            'model' => $form,
            'nameExam' => $exams[$discipline],
            'keyExam' => $discipline,
            'isBelarus' => $this->getAnketa()->isBelarus(),
        ]);
    }

    public function actionCorrectionSpo($discipline) {
        $config = ['user_id' => $this->getUserId()];
        $exams = DictCompetitiveGroupHelper::groupByExamsSpo($this->getUserId());
        if(!key_exists($discipline, $exams) && !$this->getAnketa()->onlySpo()) {
            return $this->redirect('/abiturient/default');
        }
        $form = new UserDisciplineCseForm($this->modelDiscipline($discipline), $config);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                if($form->type == UserDiscipline::NO && !UserDisciplineHelper::isSpoValid($this->getUserId(), $discipline)) {
                    throw new \DomainException("Необходимо уточнить информацию по заменяемой дисциплине");
                }
                $this->service->createOne($form, true);
                return $this->redirect('/abiturient/default');
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('_form-spo-vi', [
            'model' => $form,
            'nameExam' => $exams[$discipline],
            'keyExam' => $discipline,
            'isBelarus' => $this->getAnketa()->isBelarus(),
        ]);
    }




    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        \Yii::$app->session->setFlash("warning", "Редактирование предметов приведет к удалению выбранных образовательных 
        программ бакалавриата");

        $model = $this->findModel($id);
        $form = new UserDisciplineCseForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $form->discipline_select_id = $form->discipline_id;
                $this->service->edit($model->id, $form);
                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'userDiscipline' => $model
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): UserDiscipline
    {
        if (($model = UserDiscipline::findOne(['id'=>$id, 'user_id' => $this->getUserId()])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }


    protected function modelDiscipline($disciplineId): ?UserDiscipline
    {
        return UserDiscipline::findOne(['discipline_id'=>$disciplineId, 'user_id' => $this->getUserId()]);
    }

    /**     * @param integer $id

     * @return mixed
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    private function getIdentity()
    {
        return  Yii::$app->user->identity;
    }

    private function getUserId()
    {
        return  $this->getIdentity()->getId();
    }

    private function getAnketa(): Anketa
    {
        return  $this->getIdentity()->anketa();
    }
}