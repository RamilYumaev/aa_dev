<?php

namespace console\controllers;

use backend\models\AisCg;
use dictionary\models\ais\cathedraCgAis;
use dictionary\models\ais\CgExamAis;
use dictionary\models\ais\ExamAis;
use dictionary\models\ais\iaCgAis;
use dictionary\models\ais\iaDocAis;
use dictionary\models\DictCompetitiveGroup;
use dictionary\models\DictDiscipline;
use dictionary\models\DictSpeciality;
use dictionary\models\DictSpecialization;
use dictionary\models\DisciplineCompetitiveGroup;
use dictionary\models\Faculty;
use modules\dictionary\models\CathedraCg;
use modules\dictionary\models\DictIndividualAchievement;
use modules\dictionary\models\DictIndividualAchievementCg;
use modules\dictionary\models\DictIndividualAchievementDocument;
use yii\console\Controller;
use yii\helpers\Json;

class CopyCgController  extends Controller
{
    public function actionAisImport()
    {
        $allAisCg = AisCg::find()
            ->all();

        // echo count($allAisCg);

        $key = 0;

        foreach ($allAisCg as $aisCg) {
            $sdoCg = DictCompetitiveGroup::findCg(
                Faculty::aisToSdoConverter($aisCg->faculty_id),
                DictSpeciality::aisToSdoConverter($aisCg->specialty_id),
                DictSpecialization::aisToSdoConverter($aisCg->specialization_id),
                DictCompetitiveGroup::aisToSdoEduFormConverter($aisCg->education_form_id),
                $aisCg->financing_type_id,
                "2021-2022",
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
            $model->year = "2021-2022";
            $model->foreigner_status = $aisCg->foreigner_status;
            $model->save();
            $key++;
        }

        return " Количество итерации: " . $key . " success";
    }

    public function actionAisDisciplineImport()
    {
        $spo = [
            235 => [1,228],
            236 => [215,228],
            237 => [12,228],
            238 => [11, 228],
            239 => [3, 228],
            240 => [10, 228],
            241 => [8, 228],
            242 => [209, 228],
            243 => [222, 228],
            244 => [207, 228],
            245 => [214, 229],
            246 => [9, 229],
            247 => [203, 229],
            248 => [219, 229],
            249 => [9, 230],
            250 => [8, 231],
            251 => [9, 231],
            252 => [8, 232],
            253 => [3, 232],
            254 => [9, 232],
            255 => [8, 233],
            256 => [205, 234],
            257 => [5, 234]
        ];


        $allDiscipline = CgExamAis::find()->all();

        foreach ($allDiscipline as $discipline) {
            if(key_exists($discipline->entrance_examination_id, $spo)) {
                $disciplineId = $spo[$discipline->entrance_examination_id][0];
                $disciplineSpo = $spo[$discipline->entrance_examination_id][1];
            }else {
                $disciplineId = $discipline->entrance_examination_id;
                $disciplineSpo = null;
            }
            if (DisciplineCompetitiveGroup::findOne([
                'discipline_id' => DictDiscipline::aisToSdoConverter($disciplineId),
                'competitive_group_id' => DictCompetitiveGroup::aisToSdoConverter($discipline->competitive_group_id,
                    "2021-2022")])) {
                continue;
            } else {
                $model = new DisciplineCompetitiveGroup();
            }

            $model->discipline_id = DictDiscipline::aisToSdoConverter($disciplineId);
            $model->competitive_group_id = DictCompetitiveGroup::aisToSdoConverter(
                $discipline->competitive_group_id, "2021-2022");
            $model->priority = $discipline->priority;
            $model->spo_discipline_id = $disciplineSpo ?  DictDiscipline::aisToSdoConverter($disciplineSpo) : null;
            $model->save();
        }
        return "success";
    }

    public function actionAisDiscipline()
    {

        $allDiscipline = ExamAis::find()->where(['between', 'id',210, 234])->all();

        foreach ($allDiscipline as $discipline) {
            if (DictDiscipline::findOne([
                'ais_id' => $discipline->id])) {
                continue;
            } else {
                $model = new DictDiscipline();
            }
            $model->name = $discipline->name;
            $model->links = $discipline->site_url;
            $model->ais_id =  $discipline->id;
            $model->composite_discipline = $discipline->composite_discipline_status;
            $model->is_spec_for_spo = false;
            $model->save();
        }
        return "success";
    }

    public function actionCgCathedra($year)
    {
        $cgCathedra = cathedraCgAis::find()->andWhere(['year' => $year])->all();
        $eduYear = DictCompetitiveGroup::aisToSdoYearConverter()[$year];
        if ($cgCathedra) {
            foreach ($cgCathedra as $cathedra) {
                $cg = DictCompetitiveGroup::find()->andWhere(['ais_id' => $cathedra->competitive_group_id])->andWhere(['year' => $eduYear])->one();
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
            return "таблица cathedra-сg-ais пуста";
        }

        return "success";
    }

    public function actionIaCg()
    {
        $aisIaCg = iaCgAis::find()->all();
        if ($aisIaCg) {
            foreach ($aisIaCg as $iaAis) {
                $sdoCg = DictCompetitiveGroup::find()
                    ->andWhere(['ais_id' => $iaAis->competitive_group_id])
                    ->andWhere(['year' => "2021-2022" ])->one();
                if (!$sdoCg) {
                    return "конкурсная группа АИС $iaAis->competitive_group_id не найдена";
                }
                if ($this->getIaCg($this->getIA2022($iaAis->individual_achievement_id), $sdoCg->id)) {
                    continue;
                } else {
                    $newIaCgSdo = new DictIndividualAchievementCg();
                    $newIaCgSdo->individual_achievement_id = $this->getIA2022($iaAis->individual_achievement_id);
                    $newIaCgSdo->competitive_group_id = $sdoCg->id;
                    if (!$newIaCgSdo->save()) {
                        $error = Json::encode($newIaCgSdo->errors);
                        return "Ошибка $error";
                    }
                }
            }
        } else {
            return "Таблица individual_achievement_cg_ais пуста";
        }
        return "success";
    }

    public function actionDocIa()
    {
        $iaDoc = iaDocAis::find()->all();


        foreach ($iaDoc as $doc) {
            $ia = DictIndividualAchievement::find()->andWhere(['year' => "2021-2022"])->andWhere(['ais_id' => $doc->individual_achievement_id])->one();

            if (!$ia) {
                return "Ошибка ИД не существует";
            }

            $iaCgFind = DictIndividualAchievementDocument::find()->andWhere(['individual_achievement_id' => $ia->id])->andWhere(['document_type_id' => $doc->document_type_id])->exists();

            if ($iaCgFind) {
                continue;
            } else {
                $iaDocument = DictIndividualAchievementDocument::create($ia->id, $doc->document_type_id);
                if (!$iaDocument->save()) {
                    return "Ошибка ia $ia->id, doc $doc->document_type_id";
                };
            }

        }

        return "Удача!";
    }

    private function getIA2022($id)
    {
        $model = DictIndividualAchievement::find()
            ->andWhere(['year' => 2022])
            ->andWhere(['ais_id' => $id])
            ->one();

        return $model->id;
    }

    public function actionTransferId()
    {
        $models = DictIndividualAchievement::find()->all();

        foreach ($models as $model) {

            if ($model->year == '2022') {
                $model->ais_id = $model->id;
            } else {
                $model->ais_id = $model->id - 758;
            }

            if (!$model->save()) {
                return "Не удалось перекинуть id  $model->id";
            }
        }

        return "успешно";
    }


    private function getIaCg($iaId, $cgId)
    {
        return DictIndividualAchievementCg::find()
            ->andWhere(['individual_achievement_id' => $iaId])
            ->andWhere(['competitive_group_id' => $cgId])->exists();
    }
}