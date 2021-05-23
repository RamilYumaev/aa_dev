<?php


namespace modules\entrant\controllers\api;


use api\providers\User;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use dictionary\models\queries\DictCompetitiveGroupQuery;
use modules\dictionary\models\DictCseSubject;
use modules\dictionary\models\SettingEntrant;
use modules\entrant\models\AnketaCi;
use modules\entrant\models\AnketaCiCg;
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

    public function actionGetCgDetails($competitiveGroupId){

        $contractName = null;
        $contractId = null;
        $budgetName = null;
        $budgetId = null;
        $specialName = null;
        $specialId = null;
        $targetName = null;
        $targetId = null;
        /**
         * @var $cg DictCompetitiveGroup
         */
        $cg = DictCompetitiveGroup::findOne(['id'=>$competitiveGroupId]);

        if($cg && SettingEntrant::find()->isOpenZUK($cg)){

            $contractId =  $cg->id;
            $contractName = $cg->fullNameCg;
        }
        /**
         * @var $budgetAnalog DictCompetitiveGroup
         */
        $budgetAnalog = DictCompetitiveGroup::find()
            ->findBudgetAnalog($cg)
            ->one();
        if($budgetAnalog && SettingEntrant::find()->isOpenZUK($budgetAnalog)){

            $budgetId = $budgetAnalog->id;
            $budgetName = $budgetAnalog->fullNameCg;

        }
        /**
         * @var $specialAnalog DictCompetitiveGroup
         */

        $specialAnalog = DictCompetitiveGroup::find()
            ->findBudgetAnalog($cg, DictCompetitiveGroupHelper::SPECIAL_RIGHT)
            ->one();


        if($specialAnalog && SettingEntrant::find()->isOpenZUK($specialAnalog)){

            $specialId = $specialAnalog->id;
            $specialName = $specialAnalog->fullNameCg;
        }
        /**
         * @var $targetAnalog DictCompetitiveGroup
         */
        $targetAnalog = DictCompetitiveGroup::find()
            ->findBudgetAnalog($cg, DictCompetitiveGroupHelper::TARGET_PLACE)
            ->one();

        if($targetAnalog && SettingEntrant::find()->isOpenZUK($targetAnalog)){

            $targetId =  $targetAnalog->id;
            $targetName = $targetAnalog->fullNameCg;

        }
        $examinations = [];

        foreach ($cg->examinations as $exam){
            $examinations[] = $exam->discipline->name;
        }
        return [
            'specialty_name'=> $cg->specialty->codeWithName,
            'faculty_name'=> $cg->faculty->full_name,
            'specialization_name'=>$cg->specialization->name,
            'education_form_name'=>DictCompetitiveGroupHelper::getEduForms()[$cg->education_form_id],
            'kcp'=> $budgetAnalog->kcp ?? 0 + $specialAnalog->kcp ?? 0 + $targetAnalog->kcp ?? 0,
            'competition_count' => $budgetAnalog->competition_count ?? 0,
            'passing_score'=> $budgetAnalog->passing_score?? 0,
            'education_year_cost'=> $cg->education_year_cost,
            'education_duration'=> $cg->education_duration,
            'examinations'=> $examinations,
            'is_new_program'=> $cg->is_new_program,
            'contract_id'=> $contractId,
            'contract_name'=> $contractName,
            'budget_id'=>$budgetId,
            'budget_name'=>$budgetName,
            'special_id'=> $specialId,
            'special_name'=>$specialName,
            'target_id'=>$targetId,
            'target_name'=>$targetName,

        ];

    }

    public function actionGetAnketa(){
        $json = $this->getJson();
        $data = Json::decode($json);
        $talon = $data['talon'];
        $lastName = $data['last_name'];
        $firstName = $data['first_name'];
        $patronymic = $data['patronymic'];
        $phone = $data['phone'];
        $email = $data['email'];
        $cgs = $data['competitive_groups'];

        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $anketa = new AnketaCi();
            $anketa->talon = $talon;
            $anketa->lastName = $lastName;
            $anketa->firstName = $firstName;
            $anketa->patronymic = $patronymic;
            $anketa->phone = $phone;
            $anketa->operator_id = \Yii::$app->user->id;
            $anketa->email = $email;

            if(!$anketa->save()){
                $error = Json::encode($anketa->errors);
                return ['error_message'=>$error];
            }

            foreach ($cgs as $cg){
                $anketaCg = new AnketaCiCg();
                $anketaCg->id_anketa = $anketa->id;
                $anketaCg->competitive_group_id = $cg;
                if(!$anketaCg->save()){
                    $error = Json::encode($anketaCg->errors);
                    return ['error_message'=>$error];
                }
            }



        }catch (\Exception $e){
            $transaction->rollBack();
            throw $e;
        }
        $transaction->commit();
        return ['success_message'=>'Успешно отправлено!'];



    }

    public function actionGetDictCse(){
        $allCseSubject = DictCseSubject::find()->all();

        $cseArray = [];
        $allCseArray = [];
        foreach ($allCseSubject as $cseSubject){
            $cseArray['id'] = $cseSubject->id;
            $cseArray['name'] = $cseSubject->name;
            $cseArray['minBall'] = $cseSubject->min_mark;

            $allCseArray[] = $cseArray;
        }
        return $allCseArray;
    }

    private function validateArrayJson($key, $array){
        return array_key_exists($key, $array);
    }

    private function getJson(){
        try{
            $json = file_get_contents('php://input');
        }catch (\Exception $e){
            \Yii::error($e->getMessage());
            return ['message'=>$e->getMessage()];
        }
        return $json;
    }
}