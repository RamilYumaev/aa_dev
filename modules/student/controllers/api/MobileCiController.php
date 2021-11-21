<?php


namespace modules\student\controllers\api;


use api\providers\User;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use dictionary\models\queries\DictCompetitiveGroupQuery;
use modules\dictionary\models\DictCseSubject;
use modules\dictionary\models\SettingEntrant;
use modules\entrant\models\AnketaCi;
use modules\entrant\models\AnketaCiCg;
use modules\entrant\models\CseResultsCi;
use modules\entrant\models\Talons;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\rest\Controller;

class MobileCiController extends Controller
{
    public function behaviors()
    {
        return [
            'authenticator' => [
                'class' => CompositeAuth::class,
                'authMethods' => [
                    ['class' => HttpBasicAuth::class,
                        'auth' => function ($username, $password) {
                            $user = User::findOne(['username' => $username]);
                            $userIsValid = ($user && $user->validatePassword($password));
                            return $userIsValid ? $user : null;
                        },],
                    QueryParamAuth::class,
                ],
            ],

        ];
    }

    public function actionIndex()
    {
        return ['message' => "Ok"];
    }
}