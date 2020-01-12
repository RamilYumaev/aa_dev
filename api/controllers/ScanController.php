<?php
namespace api\controllers;

use api\providers\User;
use common\sending\helpers\SendingDeliveryStatusHelper;
use olympic\helpers\PersonalPresenceAttemptHelper;
use olympic\models\OlimpicList;
use olympic\models\PersonalPresenceAttempt;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\Controller;
use Yii;

class ScanController extends Controller
{
    public function __construct($id, $module, $config = [])
    {
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
        return ['message' => 'OK'];
    }

    /**
     * @param
     * @return array
     */
    public function actionPresence($user, $type, $value)
    {
        $user = User::findOne($user);
        if(!$user) {
            return ['message' => "Нет такого пользователя"];
        }
        if($type == SendingDeliveryStatusHelper::TYPE_OLYMPIC) {
            $olympic = OlimpicList::findOne($value);
            if(!$olympic) {
                return ['message' => "Нет такой олимпиды"];
            }
            if($olympic->isResultEndTour()) {
                return ['message' => "Такая олимпиада завершена"];
            }
            $ppt  = PersonalPresenceAttempt::find()->olympic($olympic->id);
            if(!$ppt->exists()) {
                return ['message' => "Ведомость не создана"];
            }
            $pptUser = clone $ppt->user($user->id);
            if(!$pptUser->exists()) {
                return ['message' => "Нет такого участника в ведомости"];
            }
            /* @var $pptPresence \olympic\models\PersonalPresenceAttempt; */
            $pptPresence = clone $pptUser->one();
            if ($pptPresence->isPresence()) {
                return ['message' => "Такой участник присутствует в ведомости"];
            }

            $pptPresence->setPresenceStatus(PersonalPresenceAttemptHelper::PRESENCE);
            $pptPresence->save();
            return ['message' => "Успешно добавлен"];
        }
    }
}
