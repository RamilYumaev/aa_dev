<?php

namespace modules\transfer\controllers\frontend;

use api\client\Client;
use modules\entrant\behaviors\AnketaRedirectBehavior;
use modules\transfer\behaviors\TransferRedirectBehavior;
use modules\transfer\models\TransferMpgu;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class'=> TransferRedirectBehavior::class,
                'ids'=>['index' ]
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index',['userId' => $this->getUser()]);
    }

    public function actionFix() {
        $model = $this->findModel() ?? new TransferMpgu(['user_id' => $this->getUser()]);
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if($model->isMpgu() && $model->number) {
               $data = $this->getJson($model->number);
                if(key_exists('current_status_id', $data)) {
                    $model->current_status = $data['current_status_id'];
                }
                else {
                    \Yii::$app->session->setFlash('warning',  'По данному № номеру студенческой зачетки ничего не найдено');
                    return $this->redirect(['fix']);
                }
            }else {
                $model->current_status = $model::STATUS_ACTIVE;
            }
            if($model->save()) {
                if(!in_array($model->current_status, $model::ACTIVE)) {
                    \Yii::$app->session->setFlash('danger',
                        key_exists($model->current_status, $model->listMessage()) ?
                            $model->listMessage()[$model->current_status] : 'Попробуйте в другой раз');
                    return $this->redirect(['fix']);
                }
                \Yii::$app->session->setFlash('success', 'Успешно обнолено');
                return $this->redirect(['index']);
            }
        }
        return  $this->render('form',['model' => $model ]);
    }

    public function getJson ($number) {
        $url =  '';
        //$result =  (new Client())->getData($url, ['student_record_id' => $number]);
        return json_decode('{
        "current_status_id":4,
    "faculty_id":5,
    "specialty_id":23,
    "specialization_id":13,
    "course":4,
    "education_form_id":1,
    "financing_type_id":2}',true);

        //return $result;
    }

    protected function findModel() {
        return TransferMpgu::findOne(['user_id'=> $this->getUser()]);
    }

    protected function getUser() {
        return  \Yii::$app->user->identity->getId();
    }
}
