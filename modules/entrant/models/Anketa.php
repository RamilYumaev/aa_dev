<?php

namespace modules\entrant\models;


use common\auth\models\UserSchool;
use common\helpers\EduYearHelper;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictCountryHelper;
use dictionary\models\Country;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\behaviors\AnketaBehavior;
use modules\entrant\forms\AnketaForm;
use modules\entrant\helpers\AnketaHelper;
use modules\entrant\helpers\CategoryStruct;
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
 * @property integer $is_foreigner_edu_organization
 * @property string $province_of_china
 * @property string $personal_student_number
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
        $this->province_of_china = $form->province_of_china;
        $this->personal_student_number = $form->personal_student_number;
        if ($this->userSchool && !$this->userSchool->school->isRussia()) {
            $this->is_foreigner_edu_organization = true;
        } elseif ($this->userSchool && $this->userSchool->school->isRussia()) {
            $this->is_foreigner_edu_organization = false;
        } else {
            $this->is_foreigner_edu_organization = $form->is_foreigner_edu_organization;
        }


    }

    public function isAgreement()
    {
        return $this->category_id == CategoryStruct::TARGET_COMPETITION;
    }

    public function isExemption()
    {
        return $this->category_id == CategoryStruct::SPECIAL_RIGHT_COMPETITION;
    }

    public function isPatriot()
    {
        return $this->category_id == CategoryStruct::COMPATRIOT_COMPETITION;
    }

    public function isRussia()
    {
        return $this->citizenship_id == DictCountryHelper::RUSSIA;
    }

    public function isWithOitCompetition()
    {
        return $this->category_id == CategoryStruct::WITHOUT_COMPETITION;
    }

    public function isNoRequired()
    {
        return in_array($this->category_id, CategoryStruct::UMSGroup());
    }

    public function isGovLineIncoming()
    {
        return $this->category_id == CategoryStruct::GOV_LINE_COMPETITION
            && $this->citizenship_id !== DictCountryHelper::RUSSIA;
    }

    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'citizenship_id']);
    }

    public function getCitizenship()
    {
        return $this->country->name;
    }

    public function getCategory()
    {
        return CategoryStruct::labelLists()[$this->category_id];
    }

    public function getUniversityChoice()
    {
        return AnketaHelper::universityChoice()[$this->university_choice];
    }

    public function getCurrentEduLevel()
    {
        return AnketaHelper::currentEducationLevel()[$this->current_edu_level];
    }

    public function isChina()
    {
        return $this->citizenship_id == 13;
    }


    public function attributeLabels()
    {
        return [
            'citizenship_id' => 'Какое у Вас гражданство?',
            'edu_finish_year' => 'В каком году Вы окончили последнюю образовательную организацию?',
            'current_edu_level' => 'Какой Ваш текущий уровень образования?',
            'category_id' => 'К какой категории граждан Вы относитесь?',
            'university_choice' => 'Куда Вы собираетесь подавать документы?',
            'province_of_china' => 'Из какой Вы провинции?',
            'personal_student_number' => 'Укажите персональный номер, полученный на сайте future-in-russia.com',
            'is_foreigner_edu_organization' => 'Учебная организация находится на территории иностранного государства',
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
                AnketaHelper::SPO_LEVEL_ONLY_CONTRACT))
            && $this->category_id !== CategoryStruct::GOV_LINE_COMPETITION) {
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

        return array_uintersect($result, self::existsLevel($this->university_choice), "strcasecmp");
    }

    public static function existsLevel($universityLevel)
    {
        switch ($universityLevel) {
            case AnketaHelper::HEAD_UNIVERSITY :
            {
                return DictCompetitiveGroup::find()->existsLevelInUniversity()->column();
            }
            case AnketaHelper::ANAPA_BRANCH :
            {
                return DictCompetitiveGroup::find()->existsLevelInUniversity()
                    ->andWhere(["faculty_id" => AnketaHelper::ANAPA_BRANCH])->column();
            }
            case AnketaHelper::POKROV_BRANCH :
            {
                return DictCompetitiveGroup::find()->existsLevelInUniversity()
                    ->andWhere(["faculty_id" => AnketaHelper::POKROV_BRANCH])->column();
            }
            case AnketaHelper::STAVROPOL_BRANCH :
            {
                return DictCompetitiveGroup::find()->existsLevelInUniversity()
                    ->andWhere(["faculty_id" => AnketaHelper::STAVROPOL_BRANCH])->column();
            }
            case AnketaHelper::DERBENT_BRANCH :
            {
                return DictCompetitiveGroup::find()->existsLevelInUniversity()
                    ->andWhere(["faculty_id" => AnketaHelper::DERBENT_BRANCH])->column();
            }
            case AnketaHelper::SERGIEV_POSAD_BRANCH :
            {
                return DictCompetitiveGroup::find()->existsLevelInUniversity()
                    ->andWhere(["faculty_id" => AnketaHelper::SERGIEV_POSAD_BRANCH])->column();
            }
        }
    }

    public function onlyCse()
    {
        $condition1 = $this->current_edu_level == AnketaHelper::SCHOOL_TYPE_SCHOOL
            && $this->citizenship_id == DictCountryHelper::RUSSIA
            && $this->category_id !== CategoryStruct::SPECIAL_RIGHT_COMPETITION
            && !($this->edu_finish_year == date("Y")
                && $this->is_foreigner_edu_organization); // Если обычный Российкий выпускник школы
        // и не квотник

        $condition2 = ($this->category_id == CategoryStruct::COMPATRIOT_COMPETITION ||
                in_array($this->citizenship_id, DictCountryHelper::TASHKENT_AGREEMENT))
            && ($this->current_edu_level == AnketaHelper::SCHOOL_TYPE_SCHOOL
                && $this->edu_finish_year < date("Y")); //Если из ташкентского договора или соотечественник,
        // который закончил школу не в текущем году
        return $condition1 || $condition2;

//        return (($this->current_edu_level == AnketaHelper::SCHOOL_TYPE_SCHOOL && $this->citizenship_id == 46) ||
//            (($this->category_id == CategoryStruct::COMPATRIOT_COMPETITION ||
//                    in_array($this->citizenship_id, DictCountryHelper::TASHKENT_AGREEMENT))
//                && ($this->edu_finish_year == date("Y"))));
    }

    public function onlyContract($educationLevel)
    {

        $govLine = $this->category_id === CategoryStruct::GOV_LINE_COMPETITION;

        switch ($educationLevel) {
            case DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO :
            {
                return in_array($this->current_edu_level, AnketaHelper::SPO_LEVEL_ONLY_CONTRACT);

            }
            case DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR :
            {
                return in_array($this->current_edu_level, AnketaHelper::BACHELOR_LEVEL_ONLY_CONTRACT)
                    && !$govLine;

            }
            case DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER :
            {
                return in_array($this->current_edu_level, AnketaHelper::MAGISTRACY_LEVEL_ONLY_CONTRACT)
                    && !$govLine;

            }
            case DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL :
            {
                return in_array($this->current_edu_level, AnketaHelper::HIGH_GRADUATE_LEVEL_ONLY_CONTRACT)
                    && !$govLine;

            }
        }
    }

    public function isHeadUniversity($depart)
    {
        return $depart == AnketaHelper::HEAD_UNIVERSITY;
    }

    public function isPokrov($depart)
    {
        return $depart == AnketaHelper::POKROV_BRANCH;
    }

    public function isDerbent($depart)
    {
        return $depart == AnketaHelper::DERBENT_BRANCH;
    }

    public function isSergievPosad($depart)
    {
        return $depart == AnketaHelper::SERGIEV_POSAD_BRANCH;
    }

    public function isStavropol($depart)
    {
        return $depart == AnketaHelper::STAVROPOL_BRANCH;
    }

    public function isAnapa($depart)
    {
        return $depart == AnketaHelper::ANAPA_BRANCH;
    }

    public function allowTarget()
    {
        return Agreement::findOne(['user_id' => \Yii::$app->user->identity->getId(), 'year' => EduYearHelper::eduYear()]);
    }


    public static function find()
    {
        return new AnketaQuery(static::class);
    }

    public function dataArray()
    {
        return [
            'addressNoRequired' => $this->isNoRequired(),
            'withOitCompetition' => $this->isWithOitCompetition(),
            'currentEduLevel' => AnketaHelper::currentEducationLevel()[$this->current_edu_level],
            'category_id' => $this->category_id];
    }


    public function getUserSchool()
    {
        return $this->hasMany(UserSchool::class, ['user_id' => 'user_id'])->andWhere(['edu_year' => EduYearHelper::eduYear()])->one();
    }

    public function spoNpo()
    {
        return $this->current_edu_level == AnketaHelper::SCHOOL_TYPE_NPO || $this->current_edu_level == AnketaHelper::SCHOOL_TYPE_SPO;
    }

//    public function getCategory()
//    {
//        return $this->hasOne(DictCategory::class, ['id' => 'category_id']);
//    }

}