<?php

namespace modules\transfer\controllers\frontend;

use api\client\Client;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use dictionary\models\Faculty;
use modules\transfer\behaviors\RedirectBehavior;
use modules\transfer\behaviors\TransferRedirectBehavior;
use modules\transfer\helpers\ConverterFaculty;
use modules\transfer\models\InsuranceCertificateUser;
use modules\transfer\models\PacketDocumentUser;
use modules\transfer\models\PassExam;
use modules\transfer\models\StatementTransfer;
use modules\transfer\models\TransferMpgu;
use Yii;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class'=> TransferRedirectBehavior::class,
                'ids'=>['index' ]
            ],
            [
                'class'=> RedirectBehavior::class,
                'ids'=>['fix' ]
            ],

        ];
    }

    public function actionIndex()
    {
        return $this->render('index',['transfer' => $this->findModel()]);
    }

    public function actionFix() {
        $model = $this->findModel() ?? new TransferMpgu(['user_id' => $this->getUser()]);
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if($model->isMpgu() && $model->number && $model->year) {
               $data = $this->getJson($model->number);
                if(key_exists('current_status_id', $data)) {
                    $model->current_status = $data['current_status_id'];
                    try {
                        $model->isStatusMpsuCorrectType();
                        $this->isNoGraduate($data['education_level_id']);
                    } catch (Exception $e) {
                        \Yii::$app->session->setFlash('error',  $e->getMessage());
                        return $this->redirect(['fix']);
                    }
                    $model->data_mpgsu = json_encode($data);
                }
                else {
                    \Yii::$app->session->setFlash('warning',  $data['error']);
                    return $this->redirect(['fix']);
                }
            }else {
                $model->number = '';
                $model->year = null;
                $model->current_status = $model::STATUS_ACTIVE;
                $model->data_mpgsu =null;
            }
            if($model->save()) {
                if(!in_array($model->current_status, $model::ACTIVE)) {
                    \Yii::$app->session->setFlash('danger',
                        key_exists($model->current_status, $model->listMessage()) ?
                            $model->listMessage()[$model->current_status] : 'Попробуйте в другой раз');
                    return $this->redirect(['fix']);
                }
                if(PacketDocumentUser::findOne(['user_id' => $this->getUser()])) {
                PacketDocumentUser::deleteAll(['user_id' => $this->getUser()]);
                }

                \Yii::$app->session->setFlash('success', 'Успешно обнолено');
                return $this->redirect(['index']);
            }
        }
        return  $this->render('form',['model' => $model ]);
    }

    public function actionInsuranceCertificate() {
        $model = $this->findModelNumber() ?? new InsuranceCertificateUser(['user_id' => $this->getUser()]);
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if($model->save()) {
                    return $this->redirect(['index']);
                }
        }
        return  $this->render('form-number',['model' => $model ]);
    }

    public function getJson ($number) {
        $url =  'external/incoming-abiturient/get-student-info';
        $array['student_record_id'] = $number;
        $array['token'] = \md5($number . \date('Y.m.d').Yii::$app->params['keyAisCompetitiveList']);
        $result =  (new Client(Yii::$app->params['ais_competitive']))->getData($url, $array);
        return $result;
    }

    public function actionInfo()
    {
        $statement = $this->statement();
        if ($data = Yii::$app->request->post()) {
            $transfer=  $this->findModel();
            $faculty = Faculty::findOne(['ais_id' => $transfer->getDataMpsu()['faculty_id']]);
            $facultyId = ConverterFaculty::searchFaculty($faculty->id);
            if(!$statement) {
                StatementTransfer::create($this->getUser(), $data['edu_count'], $facultyId)->save();
            }else {
                if($statement->countFiles()) {
                    \Yii::$app->session->setFlash('warning',  'Редактирование невозможно, пока в системе имеется сканированная копия документа, содержащая эти данные');
                    return $this->redirect(['post-document/index']);
                }
                $statement->faculty_id =  $facultyId;
                $statement->edu_count = $data['edu_count'];
                $statement->save();
            }

            return $this->redirect(['post-document/index']);
        }
        return $this->renderAjax('info');
    }

    public function actionNo()
    {
        $statement = $this->statement();
        /** @var PassExam $pass */
        $pass = $statement->passExam;
        if($pass && $pass->countFilesSend()&& !$pass->agree) {
            $pass->agree = 2;
            $pass->save();
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionYes()
    {
        $statement = $this->statement();
        /** @var PassExam $pass */
        $pass = $statement->passExam;
        if($pass && $pass->countFilesSend()&& !$pass->agree) {
            $pass->agree = 1;
            $pass->save();
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    protected function statement() {
        return StatementTransfer::findOne(['user_id' => $this->getUser()]);
    }

    protected function isNoGraduate($eduLevel) {
        if($eduLevel != DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL) {
            throw new Exception('Прием заявок на переводы и восстановления в летний период приема документов завершен. 
            Прием документов осуществлялся с 18 июня по 15 июля (на вакантные бюджетные места), 
            по 20 августа (на места по договору об оказании платны образовательных услуг). 
            Следующий прием документов для переводов и восстановлений будут осуществляться в зимний период приема документов (с 18 декабря по 5 февраля).
                Контакты для связи с отделом переводов и восстановлений: 8(499)233-41-81 и otdel_vp@mpgu.su');
        }
    }

    protected function findModel() {
        return TransferMpgu::findOne(['user_id'=> $this->getUser()]);
    }

    protected function findModelNumber() {
        return InsuranceCertificateUser::findOne(['user_id'=> $this->getUser()]);
    }

    protected function getUser() {
        return  \Yii::$app->user->identity->getId();
    }
}
