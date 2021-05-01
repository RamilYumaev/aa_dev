<?php
namespace modules\entrant\controllers\api;

use api\providers\User;
use common\auth\services\UserTokensService;
use Yii;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\Controller;

class AuthController extends Controller
{
    private $service;

    public function __construct($id, $module, UserTokensService  $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        return [
            'authenticator' => [
                'class' => HttpBasicAuth::class,
                'auth' => function ($username, $password) {
                    $user = User::findOne(['username' => $username]);
                    $userIsValid = ($user && $user->validatePassword($password));
                    return $userIsValid ? $user : null;
                },
            ],
        ];
    }

    public function verbs()
    {
        return [
            'index' => ['GET'],
        ];
    }

    /**
     * Для авторизации
     * @return array
     */
    public function actionIndex()
    {
        $model = $this->service->getSdoToken(Yii::$app->user->getId());
        if(!$model->profile){
            return ['message'=> 'Не заполнен профиль! Дальнейшая работа невозможна!'];
        }
        return [
            'lastName'=> $model->profile->last_name,
            'firstName'=>$model->profile->first_name,
            'patronymic'=> $model->profile->patronymic,
            'email'=>$model->profile->user->email,
            'token' => $model->token ];
    }
}
