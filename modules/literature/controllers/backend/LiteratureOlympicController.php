<?php

namespace modules\literature\controllers\backend;

use common\components\TbsWrapper;
use libphonenumber\MetadataLoaderInterface;
use modules\entrant\helpers\DateFormatHelper;
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
//        \moonland\phpexcel\Excel::widget([
//            'asAttachment'=>true,
//            'fileName' => date('d-m-Y H-i-s')."-Участники",
//            'models' => $model->all(),
//            'mode' => 'export', //default value as 'export'
//            'columns' => [
//$olympic[$key]['id',
//$olympic[$key]['user_id',
//$olympic[$key]['user.profiles.last_name',
//$olympic[$key]['user.profiles.first_name',
//$olympic[$key]['user.profiles.patronymic',
//$olympic[$key]['gender.name',
//$olympic[$key]['successName',
//$olympic[$key]['code',
//$olympic[$key]['mark_end',
//$olympic[$key]['user.profiles.phone',
//$olympic[$key]['user.email',
//$olympic[$key]['birthday:date',
//$olympic[$key]['typeName',
//$olympic[$key]['series',
//$olympic[$key]['number',
//$olympic[$key]['date_issue:date',
//$olympic[$key]['authority',
//$olympic[$key]['regionName',
//$olympic[$key]['zone',
//$olympic[$key]['city',
//$olympic[$key]['full_name',
//$olympic[$key]['short_name',
//$olympic[$key]['statusName',
//$olympic[$key]['mark_olympic',
//$olympic[$key]['grade_number',
//$olympic[$key]['gradeLetterName',
//$olympic[$key]['grade_performs',
//$olympic[$key]['fio_teacher',
//$olympic[$key]['place_work',
//$olympic[$key]['post',
//$olympic[$key]['academicName',
//$olympic[$key]['size',
//$olympic[$key]['is_allergy:boolean',
//$olympic[$key]['note_allergy:ntext',
//$olympic[$key]['is_voz:boolean',
//$olympic[$key]['is_need_conditions:boolean',
//$olympic[$key]['note_conditions:ntext',
//$olympic[$key]['note_special:ntext',
//$olympic[$key]['personals',
//$olympic[$key]['date_arrival:datetime',
//$olympic[$key]['typeTransportArrivalName',
//$olympic[$key]['place_arrival',
//$olympic[$key]['number_arrival',
//$olympic[$key]['date_departure:datetime',
//$olympic[$key]['typeTransportDepartureName',
//$olympic[$key]['place_departure',
//$olympic[$key]['number_departure',
//$olympic[$key]['created_at:datetime',
//$olympic[$key]['updated_at:datetime',
////            ], //without header working, because the header will be get label from attribute label.
////            'headers' => [
//$olympic[$key]['id' => 'ID',
//$olympic[$key]['user_id' => 'User ID',
//$olympic[$key]['user.profiles.last_name' => 'Фамилия',
//$olympic[$key]['user.profiles.first_name' => 'Имя',
//$olympic[$key]['user.profiles.patronymic' => 'Отчество',
//$olympic[$key]['genderName' => 'Пол',
//$olympic[$key]['user.profiles.phone' => 'Телефон',
//$olympic[$key]['user.email' => 'Email',
//$olympic[$key]['birthday' => 'Дата рождения',
//$olympic[$key]['type' => 'Документ, удостоверяющий личность',
//$olympic[$key]['typeName' => 'Документ, удостоверяющий личность',
//$olympic[$key]['series' => 'Серия',
//$olympic[$key]['number' => 'Номер',
//$olympic[$key]['date_issue' => 'Дата выдачи',
//$olympic[$key]['authority' => 'Кем выдан?',
//$olympic[$key]['region' => 'Регион проживания',
//$olympic[$key]['regionName' => 'Регион проживания',
//$olympic[$key]['zone' => 'Район/область',
//$olympic[$key]['city' => 'Город/населенный пункт проживания',
//$olympic[$key]['full_name' => 'Полное наименование общеобразовательной организации (по уставу)',
//$olympic[$key]['short_name' => 'Сокращенное наименование общеобразовательной организации (по уставу)',
//$olympic[$key]['status_olympic' => 'Статус участника олимпиады',
//$olympic[$key]['statusName' => 'Статус участника олимпиады',
//$olympic[$key]['mark_olympic' => 'Кол-во набранных баллов на региональном этапе в 2021/2022 учебном году',
//$olympic[$key]['grade_number' => 'Класс, в котором обучается участник',
//$olympic[$key]['grade_letter' => 'Литер',
//$olympic[$key]['gradeLetterName' => 'Литер',
//$olympic[$key]['grade_performs' => 'Класс, за который выступает участник',
//$olympic[$key]['fio_teacher' => 'ФИО наставника, подготовившего участника олимпиады',
//$olympic[$key]['place_work' => 'Место работы наставника',
//$olympic[$key]['post' => 'Должность наставника',
//$olympic[$key]['academic_degree' => 'Ученая степень',
//$olympic[$key]['academicName' => 'Ученая степень',
//$olympic[$key]['size' => 'Размер футболки',
//$olympic[$key]['is_allergy' => 'Есть ли аллергия на продукты питания и/или медицинские препараты?',
//$olympic[$key]['note_allergy' => "Укажите, на какие именно продукты питания и/или медицинские препараты есть аллергия",
//$olympic[$key]['is_voz' => 'Относится ли участник к категории детей-инвалидов, инвалидов, детей с ОВЗ?',
//$olympic[$key]['is_need_conditions' => 'Нуждается ли участник в специальных условиях при организации олимпиад?',
//$olympic[$key]['note_conditions' => 'Укажите, какие специальные условия необходимо создать при организации олимпиады?',
//$olympic[$key]['note_special' => 'Особые сведения (непереносимость медицинских препаратов, хронический заболевания, о которых необходимо знать организаторам)',
//$olympic[$key]['created_at' => 'Дата создания записи',
//$olympic[$key]['updated_at' => 'Дата обновления записи',
//$olympic[$key]['date_arrival' => 'Дата и время прилета/приезда',
//$olympic[$key]['type_transport_arrival' => 'Вид транспорта',
//$olympic[$key]['typeTransportArrivalName' => 'Вид транспорта',
//$olympic[$key]['place_arrival' => 'Место прибытия (аэропорт/ ж/д вокзал, автовокзал и т.д.)',
//$olympic[$key]['number_arrival' => 'Номер рейса самолета или номер поезда и вагона',
//$olympic[$key]['date_departure' => 'Дата и время вылета/выезда',
//$olympic[$key]['type_transport_departure' => 'Вид транспорта',
//$olympic[$key]['typeTransportDepartureName' => 'Вид транспорта',
//$olympic[$key]['place_departure' => 'Место отбытия (аэропорт/ ж/д вокзал, автовокзал и т.д.)',
//$olympic[$key]['number_departure' => 'Номер рейса самолета или номер поезда и вагона',
//$olympic[$key]['successName'=> "Подтвержден?",
//$olympic[$key]['code' => 'Шифр',
//$olympic[$key]['mark_end' => "Итоговая оценка",
//$olympic[$key]['personals' => 'Сопровождающие'
//            ],
//        ]);
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
     */
    public function actionCreate()
    {
        $model = new LiteratureOlympic();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
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
        $model->save();

        return $this->redirect(['index']);
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
