<?php


namespace modules\entrant\controllers\api;


use api\providers\User;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\dictionary\models\SettingEntrant;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
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
        return ['message' => "Okay"];
    }

    public function actionGetCgs($educationLevelId)
    {
        $cgsArray = [];
        $cgs = [];
        $model = DictCompetitiveGroup::find()
            ->eduLevel($educationLevelId)
            ->tpgu(false)
            ->contractOnly()
            ->foreignerStatus(false)
            ->currentAutoYear()
            ->withoutBranch()
            ->all();

       // $key = 1;

        foreach ($model as $cg) {
            if (!SettingEntrant::find()->isOpenFormZUK($cg)) {
                continue;
            }
            $cgs['examinations_id'] = [];
            $cgs['competitive_group_id'] = $cg->id;
            $cgs['faculty_name'] = $cg->faculty->full_name;
            $cgs['specialty_name'] = $cg->specialty->codeWithName;
            $cgs['specialization_name'] = $cg->specialization->name;
            $cgs['education_form_name'] = DictCompetitiveGroupHelper::getEduForms()[$cg->education_form_id];
            $cgs['cg_name'] = $cg->fullNameCg;

            foreach ($cg->examinations as $examination) {
                $cgs['examinations_id'][] = $examination->discipline->id;
            }
            $cgsArray[] = $cgs;

          //  $key++;


        }
        return $cgsArray;
    }
}