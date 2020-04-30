<?php

namespace modules\entrant\models;


use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictCountryHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\dictionary\models\DictCategory;
use modules\entrant\behaviors\AnketaBehavior;
use modules\entrant\forms\AnketaForm;
use modules\entrant\helpers\AnketaHelper;
use modules\entrant\models\queries\AnketaQuery;
use yii\db\ActiveRecord;

/**
 * Class Anketa
 * @package modules\entrant\models
 * @property integer $id
 * @property integer $user_id
 * @property string $citizenship_id
 * @property integer $edu_finish_year
 * @property string $current_edu_level
 * @property string $category_id
 * @property integer $university_choice
 */
class Anketa extends ActiveRecord
{
    public static function tableName()
    {
        return "{{%anketa}}";
    }

    public function behaviors()
    {
        return [
            [
                'class' => AnketaBehavior::class,
            ],
        ];
    }

    public static function create(AnketaForm $form)
    {
        $anketa = new static();
        $anketa->data($form);
        return $anketa;
    }

    public function data(AnketaForm $form)
    {
        $this->citizenship_id = $form->citizenship_id;
        $this->edu_finish_year = $form->edu_finish_year;
        $this->current_edu_level = $form->current_edu_level;
        $this->category_id = $form->category_id;
        $this->user_id = $form->user_id;
        $this->university_choice = $form->university_choice;

    }

    public function isAgreement()
    {
        return $this->category_id == 4;
    }

    public function isExemption()
    {
        return $this->category_id == 2;
    }

    public function isPatriot()
    {
        return $this->category_id == 3;
    }

//    public function titleModeration(): string
//    {
//        return "Анкета";
//    }

    public function attributeLabels()
    {
        return [
            'citizenship_id' => 'Какое у Вас гражданство?',
            'edu_finish_year' => 'В каком году Вы окончили последнюю образовательную организацию?',
            'current_edu_level' => 'Какой Ваш текущий уровень образования?',
            'category_id' => 'К какой категории граждан Вы относитесь?',
            'university_choice' => 'В какой вуз Вы собираетесь подавать документы?',
        ];
    }

//    public function moderationAttributes($value): array
//    {
//        return [
//            'citizenship_id' => $value,
//            'edu_finish_year' => $value,
//            'current_edu_level'=> $value,
//            'category_id'=> $value,
//        ];
//    }

    public function getPermittedEducationLevels(): array
    {

        $result = [];
        if (in_array($this->current_edu_level, array_merge(
            AnketaHelper::SPO_LEVEL,
            AnketaHelper::SPO_LEVEL_ONLY_CONTRACT))) {
            $result[] = DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO;
        }
        if (in_array($this->current_edu_level, array_merge(
            AnketaHelper::BACHELOR_LEVEL,
            AnketaHelper::BACHELOR_LEVEL_ONLY_CONTRACT))
        ) {
            $result[] = DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR;
        }
        if (in_array($this->current_edu_level, array_merge(
            AnketaHelper::MAGISTRACY_LEVEL,
            AnketaHelper::MAGISTRACY_LEVEL_ONLY_CONTRACT))
        ) {
            $result[] = DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER;
        }
        if (in_array($this->current_edu_level, array_merge(
            AnketaHelper::HIGH_GRADUATE_LEVEL,
            AnketaHelper::HIGH_GRADUATE_LEVEL_ONLY_CONTRACT))
        ) {
            $result[] = DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL;
        }

        return array_uintersect($result, self::existsLevel($this->university_choice),"strcasecmp");
    }

    public static function existsLevel($universityLevel)
    {
        switch ($universityLevel) {
            case AnketaHelper::HEAD_UNIVERSITY : {
                return DictCompetitiveGroup::find()->existsLevelInUniversity()->column();
            }
            case AnketaHelper::ANAPA_BRANCH : {
                return DictCompetitiveGroup::find()->existsLevelInUniversity()
                    ->andWhere(["faculty_id"=> AnketaHelper::ANAPA_BRANCH])->column();
            }
            case AnketaHelper::POKROV_BRANCH : {
                return DictCompetitiveGroup::find()->existsLevelInUniversity()
                    ->andWhere(["faculty_id"=> AnketaHelper::POKROV_BRANCH])->column();
            }
            case AnketaHelper::STAVROPOL_BRANCH : {
                return DictCompetitiveGroup::find()->existsLevelInUniversity()
                    ->andWhere(["faculty_id"=> AnketaHelper::STAVROPOL_BRANCH])->column();
            }
            case AnketaHelper::DERBENT_BRANCH : {
                return DictCompetitiveGroup::find()->existsLevelInUniversity()
                    ->andWhere(["faculty_id"=> AnketaHelper::DERBENT_BRANCH])->column();
            }
            case AnketaHelper::SERGIEV_POSAD_BRANCH : {
                return DictCompetitiveGroup::find()->existsLevelInUniversity()
                    ->andWhere(["faculty_id"=> AnketaHelper::SERGIEV_POSAD_BRANCH])->column();
            }
        }
    }

    public function onlyCse()
    {
        return (in_array($this->citizenship_id, DictCountryHelper::TASHKENT_AGREEMENT)
                && $this->current_edu_level == AnketaHelper::SCHOOL_TYPE_SCHOOL) ||
            ($this->category->foreigner_status && ($this->edu_finish_year < date("Y")));
    }

    public function onlyContract($educationLevel)
    {
        switch ($educationLevel) {
            case DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO :
            {
                return in_array($this->current_edu_level, AnketaHelper::SPO_LEVEL_ONLY_CONTRACT);
                break;
            }
            case DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR :
            {
                return in_array($this->current_edu_level, AnketaHelper::BACHELOR_LEVEL_ONLY_CONTRACT);
                break;
            }
            case DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER :
            {
                return in_array($this->current_edu_level, AnketaHelper::MAGISTRACY_LEVEL_ONLY_CONTRACT);
                break;
            }
            case DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL :
            {
                return in_array($this->current_edu_level, AnketaHelper::HIGH_GRADUATE_LEVEL_ONLY_CONTRACT);
                break;
            }
        }
    }


    public static function find()
    {
        return new AnketaQuery(static::class);
    }

    public function getCategory()
    {
        return $this->hasOne(DictCategory::class, ['id' => 'category_id']);
    }

}