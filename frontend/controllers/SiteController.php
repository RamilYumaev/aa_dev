<?php

namespace frontend\controllers;

use backend\models\AisCg;
use common\auth\Identity;
use dictionary\models\ais\cathedraCgAis;
use dictionary\models\ais\CgExamAis;
use dictionary\models\DictCompetitiveGroup;
use dictionary\models\DictDiscipline;
use dictionary\models\DictSpeciality;
use dictionary\models\DictSpecialization;
use dictionary\models\DisciplineCompetitiveGroup;
use dictionary\models\Faculty;
use frontend\components\redirect\actions\ErrorAction;
use frontend\components\UserNoEmail;
use modules\dictionary\models\CathedraCg;
use yii\helpers\Json;
use yii\web\Controller;
use Yii;
use common\auth\models\User;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    const LOG_FILE_PATH_NAME = '@frontendRuntime/logs/app.log';

    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

//    public function beforeAction($action)
//    {
//      // return (new UserNoEmail())->redirect();
//    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "@frontend/views/layouts/frontPage.php";
        //   \Yii::$app->user->switchIdentity();
        return $this->render('index');
    }

    public function actionSwitchUser($id)
    {
//        $initialId = \Yii::$app->user->getId();
//        if ($id !== $initialId) {
//            $userModel = User::findOne($id);
//            $user = new Identity($userModel);
//            $duration = 0;
//            Yii::$app->user->switchIdentity($user, $duration);
//            if(!Yii::$app->session->get('user.idbeforeswitch'))
//            {
//                Yii::$app->session->set('user.idbeforeswitch', $initialId);
//            }
        //}


        return $this->render('index');

    }

//    public function actionTransformPhone()
//    {
//        set_time_limit(6000);
//        $profile = Profiles::find()->all();
//
//        foreach ($profile as $item) {
//            //$phone = str_replace(array('+', ' ', '(', ')', '-'), '', $item->phone);
//
//            if (stristr($item->phone, "+")) {
//                continue;
//            } else {
//                $item->phone = "+" . $item->phone;
//            }
//
//
//            if (!$item->save()) {
//                throw new \DomainException("ошибка при сохранении");
//            }
//        }
//
//        return "finish";
//    }


    public function actionAisImport($year)
    {
        $allAisCg = AisCg::find()
            ->andWhere(['year' => $year])
            ->all();

        echo count($allAisCg);

        $key = 0;

        foreach ($allAisCg as $aisCg) {
            $sdoCg = DictCompetitiveGroup::findCg(
                Faculty::aisToSdoConverter($aisCg->faculty_id),
                DictSpeciality::aisToSdoConverter($aisCg->specialty_id),
                DictSpecialization::aisToSdoConverter($aisCg->specialization_id),
                DictCompetitiveGroup::aisToSdoEduFormConverter($aisCg->education_form_id),
                $aisCg->financing_type_id,
                DictCompetitiveGroup::aisToSdoYearConverter()[$aisCg->year],
                $aisCg->special_right_id, $aisCg->foreigner_status, $aisCg->spo_class);

            if ($sdoCg !== null) {
                $model = $sdoCg;
            } else {
                $model = new DictCompetitiveGroup();
            };
            $model->speciality_id = DictSpeciality::aisToSdoConverter($aisCg->specialty_id);
            $model->specialization_id = DictSpecialization::aisToSdoConverter($aisCg->specialization_id);
            $model->education_form_id = DictCompetitiveGroup::aisToSdoEduFormConverter($aisCg->education_form_id);
            $model->financing_type_id = $aisCg->financing_type_id;
            $model->faculty_id = Faculty::aisToSdoConverter($aisCg->faculty_id);
            $model->kcp = $aisCg->kcp;
            $model->special_right_id = $aisCg->special_right_id;
            $model->passing_score = $aisCg->competition_mark;
            $model->is_new_program = $aisCg->is_new_status;
            $model->competition_count = $aisCg->competition_count;
            $model->only_pay_status = $aisCg->contract_only_status;
            $model->edu_level = DictCompetitiveGroup::aisToSdoEduLevelConverter($aisCg->education_level_id);
            $model->education_duration = $aisCg->education_duration;
            $model->education_year_cost = $aisCg->education_year_cost;
            $model->discount = $aisCg->discount;
            $model->enquiry_086_u_status = $aisCg->enquiry_086_u_status;
            $model->spo_class = $aisCg->spo_class;
            $model->ais_id = $aisCg->id;
            $model->link = $aisCg->site_url;
            $model->year = DictCompetitiveGroup::aisToSdoYearConverter()[$aisCg->year];
            $model->foreigner_status = $aisCg->foreigner_status;
            $model->save();
            $key++;
        }

        return " Количество итерации: " . $key . " success";
    }

    public function actionAisDisciplineImport($year)
    {
        $allDiscipline = CgExamAis::find()->andWhere(["year" => $year])->all();

        foreach ($allDiscipline as $discipline) {
            if (DisciplineCompetitiveGroup::findOne([
                'discipline_id' => DictDiscipline::aisToSdoConverter($discipline->entrance_examination_id),
                'competitive_group_id' => DictCompetitiveGroup::aisToSdoConverter($discipline->competitive_group_id,
                    DictCompetitiveGroup::aisToSdoYearConverter()[$year])])) {
                continue;
            } else {
                $model = new DisciplineCompetitiveGroup();
            }

            $model->discipline_id = DictDiscipline::aisToSdoConverter($discipline->entrance_examination_id);
            $model->competitive_group_id = DictCompetitiveGroup::aisToSdoConverter(
                $discipline->competitive_group_id, DictCompetitiveGroup::aisToSdoYearConverter()[$year]);
            $model->priority = $discipline->priority;
            $model->save();
        }
        return "success";
    }

    public function actionCgCathedra($year)
    {
        $cgCathedra = cathedraCgAis::find()->andWhere(['year' => $year])->all();
        if ($cgCathedra) {
            foreach ($cgCathedra as $cathedra) {
                $cg = DictCompetitiveGroup::find()->andWhere(['ais_id' => $cathedra->competitive_group_id])->one();
                if (!$cg) {
                    return "Отсутствует конкурсная группа $cathedra->competitive_group_id";
                }
                if (CathedraCg::find()
                    ->andWhere(['cg_id' => $cg->id, 'cathedra_id' => $cathedra->cathedra_id])
                    ->exists()) {
                    continue;
                }
                $sdoCathedraCg = new CathedraCg();
                $sdoCathedraCg->cg_id = $cg->id;
                $sdoCathedraCg->cathedra_id = $cathedra->cathedra_id;
                if (!$sdoCathedraCg->save()) {
                    $errors = Json::encode($sdoCathedraCg->errors);
                    return "Ошибка $errors";
                }
            }

        } else {
            return "таблица cathedra-сg-фis пуста";
        }

        return "success";
    }

    public function actionClearCache()
    {
        $frontendAssets = Yii::getAlias("@frontend") . "/web/assets";
        $backendAssets = Yii::getAlias("@backend") . "/web/assets";

        self::removeDir($frontendAssets);
        self::removeDir($backendAssets);

        return "Папки assets очищены";
    }

    public function actionLogView()
    {
        $logFile = \Yii::getAlias(self::LOG_FILE_PATH_NAME);
        return $this->render('log-view', ['logFile' => $logFile]);
    }

    public function actionAppLogClear()
    {
        $logFile = \Yii::getAlias(self::LOG_FILE_PATH_NAME);
        \file_put_contents($logFile, '');

        return $this->redirect(['log-view']);
    }

    private static function removeDir($dir)
    {
        foreach (\glob($dir . '/*') as $file) {
            if (\is_dir($file)) {
                self::removeDir($file);
            } else {
                \unlink($file);
            }
        }
    }

}
