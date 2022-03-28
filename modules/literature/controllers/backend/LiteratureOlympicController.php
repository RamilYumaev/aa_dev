<?php

namespace modules\literature\controllers\backend;

use common\auth\models\User;
use common\components\TbsWrapper;
use libphonenumber\MetadataLoaderInterface;
use modules\entrant\helpers\DateFormatHelper;
use modules\literature\forms\RegisterForm;
use Mpdf\Tag\Li;
use olympic\forms\auth\UserCreateForm;
use olympic\helpers\auth\ProfileHelper;
use olympic\models\auth\Profiles;
use Yii;
use modules\literature\models\LiteratureOlympic;
use modules\literature\forms\search\LiteratureOlympciSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LiteratureOlympicController implements the CRUD actions for LiteratureOlympic model.
 */
class LiteratureOlympicController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'success' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all LiteratureOlympic models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LiteratureOlympciSearch();
        $dataProvider =  new ActiveDataProvider([
            'query' => $searchModel->search(Yii::$app->request->queryParams)
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExport()
    {
        $searchModel = new LiteratureOlympciSearch();

        $model = $searchModel->search(Yii::$app->request->queryParams);

        $fileName =  date('d-m-Y H-i-s')."-Участники".".xlsx";
        $filePath =   \Yii::getAlias('@common').'/file_templates/olympic.xlsx';
        $dataApp = $this->getOlympic($model->all());
        $this->openFile($filePath,  $dataApp, $fileName);
    }

    public function openFile($filePath, $dataApp, $fileName) {
        $tbs = new TbsWrapper();
        $tbs->openTemplate($filePath);
        $tbs->merge('olympic', $dataApp);
        $tbs->download($fileName);
    }

    private function getOlympic($model)
    {
        $i = 0;
        $olympic = [];
        /**
         * @var  $key
            * @var  LiteratureOlympic $item */
        foreach ($model as $key => $item) {
            $olympic[$key]['num'] = ++$i;
            $olympic[$key]['id'] = $item->id;
            $olympic[$key]['user_id'] = $item->user_id;
            $olympic[$key]['last_name'] = $item->user->profiles->last_name;
            $olympic[$key]['first_name'] = $item->user->profiles->first_name;
            $olympic[$key]['patronymic'] = $item->user->profiles->patronymic;
            $olympic[$key]['sex'] = $item->getGenderName();
            $olympic[$key]['is_success'] = $item->getSuccessName();
            $olympic[$key]['code'] = $item->code;
            $olympic[$key]['mark_end'] = $item->mark_end;
            $olympic[$key]['code_two'] = $item->code_two;
            $olympic[$key]['mark_end_two'] = $item->mark_end_two;
            $olympic[$key]['code_three'] = $item->code_three;
            $olympic[$key]['mark_end_three'] = $item->mark_end_three;
            $olympic[$key]['mark_end_last'] = $item->mark_end_last;
            $olympic[$key]['status_last'] = $item->getStatusUserName();
            $olympic[$key]['phone'] = $item->user->profiles->phone;
            $olympic[$key]['email'] = $item->user->email;
            $olympic[$key]['birthday'] = DateFormatHelper::formatView($item->birthday);
            $olympic[$key]['type'] = $item->getTypeName();
            $olympic[$key]['series'] = $item->series;
            $olympic[$key]['number'] = $item->number;
            $olympic[$key]['date_issue'] = DateFormatHelper::formatView($item->date_issue);
            $olympic[$key]['authority'] = $item->authority;
            $olympic[$key]['region'] = $item->getRegionName();
            $olympic[$key]['zone'] = $item->zone;
            $olympic[$key]['city'] = $item->city;
            $olympic[$key]['full_name'] = $item->full_name;
            $olympic[$key]['short_name'] = $item->short_name;
            $olympic[$key]['status'] = $item->getStatusName();
            $olympic[$key]['mark_olympic'] = $item->mark_olympic;
            $olympic[$key]['grade_number'] = $item->grade_number;
            $olympic[$key]['grade_letter'] = $item->getGradeLetterName();
            $olympic[$key]['grade_performs'] = $item->grade_performs;
            $olympic[$key]['fio_teacher'] = $item->fio_teacher;
            $olympic[$key]['place_work'] = $item->place_work;
            $olympic[$key]['post'] = $item->post;
            $olympic[$key]['academic'] = $item->getAcademicName();
            $olympic[$key]['size'] = $item->size;
            $olympic[$key]['is_allergy'] = $item->is_allergy ? "Да": "Нет";
            $olympic[$key]['note_allergy'] = $item->note_allergy;
            $olympic[$key]['is_voz'] = $item->is_voz ? "Да": "Нет";
            $olympic[$key]['is_need_conditions'] = $item->is_need_conditions? "Да": "Нет";
            $olympic[$key]['note_conditions'] = $item->note_conditions;
            $olympic[$key]['note_special'] = $item->note_special;
            $olympic[$key]['personals'] = $item->getPersonals();
            $olympic[$key]['date_arrival'] = $item->date_arrival;
            $olympic[$key]['transport_arrival'] = $item->getTypeTransportArrivalName();
            $olympic[$key]['place_arrival'] = $item->place_arrival;
            $olympic[$key]['number_arrival'] = $item->number_arrival;
            $olympic[$key]['date_departure'] = $item->date_departure;
            $olympic[$key]['transport_departure'] = $item->getTypeTransportDepartureName();
            $olympic[$key]['place_departure'] = $item->place_departure;
            $olympic[$key]['number_departure'] = $item->number_departure;
        }
        return $olympic;
    }

    /**
     * Displays a single LiteratureOlympic model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new LiteratureOlympic model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \Exception
     */
    public function actionCreate()
    {
        $model = new RegisterForm();
        $literature = new LiteratureOlympic();
        if ($model->load(Yii::$app->request->post()) && $literature->load(Yii::$app->request->post())   && $model->validate()) {
            $transaction = \Yii::$app->db->beginTransaction();
            try{
            $formUser = new UserCreateForm();
            $formUser->username = $model->user->username;
            $formUser->email = $model->user->email;
            $formUser->password = $model->user->password;
            $user = User::create($formUser);
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();
            $user->status = 10;
            $user->save();
            $userId = $user->id;
            $profile = Profiles::create($model->profile, $userId);
            $profile->setRole(ProfileHelper::ROLE_STUDENT);
            $profile->save();
                $literature->user_id = $userId;
                $literature->birthday = DateFormatHelper::formatRecord($literature->birthday);
                $literature->date_issue = DateFormatHelper::formatRecord($literature->date_issue);
                $literature->save();
            $transaction->commit();
            return $this->redirect(['view', 'id' => $literature->id]);
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
            }
        }

        return $this->render('create', [
            'model' => $model,
            'literature' => $literature,
        ]);
    }

    /**
     * @param $id
     * @param $name
     * @return \yii\console\Response|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionGetFile($id, $name)
    {
        $model = $this->findModel($id);
        if (!$model) {
            throw new NotFoundHttpException('Страница не найдена');
        }
        $filePath = $model->getUploadedFilePath($name);
        if (!file_exists($filePath)) {
            Yii::$app->session->setFlash('danger', "Файл не найден");
            return $this->redirect(Yii::$app->request->referrer);
        }
        return Yii::$app->response->sendFile($filePath);
    }

    /**
     * Updates an existing LiteratureOlympic model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->birthday = DateFormatHelper::formatView($model->birthday);
        $model->date_issue = DateFormatHelper::formatView($model->date_issue);

        if ($model->load(Yii::$app->request->post())) {
            $model->birthday = DateFormatHelper::formatRecord($model->birthday);
            $model->date_issue = DateFormatHelper::formatRecord($model->date_issue);
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing LiteratureOlympic model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionSuccess($id)
    {
        $model = $this->findModel($id);
        $model->is_success = true;
        if(!$model->save()) {
            Yii::$app->session->setFlash('danger', "Не все данные внесены, поэтому подтверждение невозможно");
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Deletes an existing LiteratureOlympic model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LiteratureOlympic model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LiteratureOlympic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LiteratureOlympic::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
