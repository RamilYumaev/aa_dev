<?php

namespace frontend\controllers;

use common\auth\models\User;
use common\components\JsonAjaxField;
use frontend\search\Profile;
use olympic\helpers\auth\ProfileHelper;
use olympic\models\auth\Profiles;
use olympic\services\auth\UserService;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class SwitchUserController extends Controller
{
    private $service;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'get-list', 'by-user-id'],
                        'allow' => true,
                        'roles' => ['call-center'],
                    ],
                    [
                        'actions' => ['come-back'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function __construct($id, $module, UserService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public function actionIndex()
    {
        $model = new Profile();
        $params = \Yii::$app->request->queryParams;
        $isParams= $params ? true  : false;
        $model->load($params);
        if(\Yii::$app->request->post()) {
          try {
              $user = $this->service->createByOperator($model);
              \Yii::$app->user->identity->switchUser($user->id);
              return $this->goHome();
          } catch (Exception $e) {
              \Yii::$app->session->setFlash('danger', $e->getMessage());
          }
        }
        return $this->render('index', ['model' => $model,
            'isParams' => $isParams,
            'user' => $this->findUser($model->email),
            'phone' => $this->findProfilePhone($model->phone),
            'listProfiles' => $this->findProfileFIO($model->last_name, $model->first_name, $model->patronymic)
        ]);
    }

    protected function findUser($email)
    {
        return User::findOne(['email' => $email]);
    }

    protected function findProfilePhone($phone)
    {
        return Profiles::findOne(['phone' => "+".$phone]);
    }



    protected function findProfileFIO($lastName, $firstName, $patronymic)
    {
        return Profiles::find()
            ->andFilterWhere(['like', 'last_name', $lastName])
            ->andFilterWhere(['like', 'first_name', $firstName])
            ->andFilterWhere(['like', 'patronymic', $patronymic])->all();
    }

    public function actionByUserId($id)
    {
        \Yii::warning("в сессии ".\Yii::$app->session->get('user.idbeforeswitch'));
        try {
            \Yii::$app->user->identity->switchUser($id);
            return $this->goHome();
        } catch (\Exception $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->goHome();
    }


    public function actionComeBack()
    {
        if ($adminUser = \Yii::$app->session->get('user.idbeforeswitch')) {
            \Yii::$app->user->identity->switchUser($adminUser);
            \Yii::$app->session->remove('user.idbeforeswitch');
        } else {
            \Yii::$app->session->setFlash('error', 'Ошибка. Потерян идентификационный ключ администратора.');
            return $this->redirect('/account/logout');
        }
        return $this->goHome();
    }


    public function actionGetList($submittedStatus, $countryId, $regionId)
    {
        if ($regionId == "") {
            $regionId = null;
        }
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $array = ProfileHelper::getListForSwitch($submittedStatus, $countryId, $regionId);
        return ['result' => JsonAjaxField::dataSwitcher($array)];
    }

}