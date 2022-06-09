<?php
namespace modules\entrant\controllers\backend;

use modules\entrant\models\Talons;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class QueueController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['dev','call-center']
                    ]
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        $talons = Talons::find()
            ->andWhere(['date'=> date("Y-m-d")])
            ->andWhere(['status'=> Talons::STATUS_NEW,
                'num_of_table' => null])->all();

        return $this->render('index',['talons' => $talons]);
    }

    public function actionWorks()
    {
        $talons = Talons::find()
            ->andWhere(['date'=> date("Y-m-d")])
            ->andWhere(['user_id' => $this->getUser()])->all();
        return $this->render('index',['talons' => $talons]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionWatting($id)
    {
        $model = Talons::findOne(['id'=>$id,
            'num_of_table' => null,
            'user_id' => null,
            'date'=> date("Y-m-d")]);
        if(!$model) {
            throw  new NotFoundHttpException('Талона не существует');
        }
        $this->exits();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $model->user_id = $this->getUser();
            $model->status = Talons::STATUS_WAITING;
            if($this->exitsTable($model->num_of_table)) {
                \Yii::$app->session->setFlash('warning', 'Cтол '.$model->num_of_table.' уже занят');
                return $this->redirect(['index']);
            }
            if($model->save()) {
                \Yii::$app->session->setFlash('success', 'Успешно обновлено');
                return $this->redirect(['works']);
            }
        }
        return $this->renderAjax('watting',['model' => $model ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionDanger($id)
    {
        $model = Talons::findOne(['id'=>$id,
            'user_id' => $this->getUser(),
            'date'=> date("Y-m-d")]);
        if(!$model) {
            throw  new NotFoundHttpException('Талона не существует');
        }
        $model->user_id = null;
        $model->status = Talons::STATUS_NEW;
        $model->num_of_table = null;
        if($model->save()) {
           return $this->redirect(['index']);
        }
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionSuccess($id)
    {
        $model = Talons::findOne(['id'=>$id,
            'user_id' => $this->getUser(),
            'status' => Talons::STATUS_WORK,
            'date'=> date("Y-m-d")]);
        if(!$model) {
            throw  new NotFoundHttpException('Талона не существует');
        }
        $model->status = Talons::STATUS_FINISHED;
        if($model->save()) {
            return $this->redirect(['index']);
        }
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionWork($id)
    {
        $model = Talons::findOne(['id'=>$id,
            'user_id' => $this->getUser(),
            'status' => Talons::STATUS_WAITING,
            'date'=> date("Y-m-d")]);
        if(!$model) {
            throw  new NotFoundHttpException('Талона не существует');
        }
        $model->status = Talons::STATUS_WORK;
        if($model->save()) {
            $anketa = $model->anketaCi;
             $urlParams = Yii::$app->urlManager->createUrl($anketa ? ['switch-user','last_name'=>$anketa->lastName, 'first_name' => $anketa->firstName,
                'patronymic' => $anketa->patronymic, 'email'=>$anketa->email, 'phone' => $anketa->phone] : [
                    'switch-user/by-user-id', 'id' => $model->entrant_id]
             );
            $url = Url::to('@frontendInfo'.$urlParams,true);
             return $this->redirect($url);
        }
    }

    protected function getUser() {
        return \Yii::$app->user->identity->getId();
    }

    protected function exits() {
        if(Talons::find()
            ->andWhere(['date'=> date("Y-m-d")])
            ->andWhere(['user_id' => $this->getUser(), 'status'=> [Talons::STATUS_WAITING, Talons::STATUS_WORK]])->exists()) {
            \Yii::$app->session->setFlash('warning', 'Вы уже взяли или в работе');
            return $this->redirect(['works']);
        }
    }

    protected function exitsTable($number) {
        return Talons::find()
            ->andWhere(['date'=> date("Y-m-d")])
            ->andWhere([ 'num_of_table' => $number,
                'status'=> [Talons::STATUS_WAITING, Talons::STATUS_WORK]])->exists();
    }


}