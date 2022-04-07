<?php

namespace modules\entrant\models;


use common\auth\models\User;
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
use olympic\models\auth\Profiles;
use yii\db\ActiveRecord;

/**
 * Class Anketa
 * @package modules\entrant\models
 * @property integer $id
 * @property integer $user_id
 * @property string $citizenship_id
 * @property string $current_edu_level
 * @property string $category_id
 * @property integer $university_choice
 * @property integer $is_foreigner_edu_organization
 * @property integer $speciality_spo
 * @property string $province_of_china
 * @property string $personal_student_number
 * @property boolean $is_agree
 * @property boolean $is_dlnr_ua
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
        $this->is_agree = $form->is_agree;
        $this->current_edu_level = $form->current_edu_level;
        $this->category_id = $form->category_id;
        $this->user_id = $form->user_id;
        $this->province_of_china = $form->province_of_china;
        $this->speciality_spo = $form->speciality_spo;
        $this->personal_student_number = $form->personal_student_number;
        $this->is_dlnr_ua = $form->is_dlnr_ua;
        if ($this->userSchool && !$this->userSchool->school->isRussia()) {
            $this->is_foreigner_edu_organization = true;
        } elseif ($this->userSchool && $this->userSchool->school->isRussia()) {
            $this->is_foreigner_edu_organization = false;
        } else {
            $this->is_foreigner_edu_organization = $form->is_foreigner_edu_organization;
        }
    }
    public function isTpgu()
    {
        return $this->category_id == CategoryStruct::TPGU_PROJECT;
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

    public function isMoscow()
    {
        return $this->university_choice == AnketaHelper::HEAD_UNIVERSITY;
    }

    public function isBelarus()
    {
        return $this->citizenship_id ==  DictCountryHelper::BELARUS;
    }

    public function attributeLabels()
    {
        return [
            'citizenship_id' => 'Какое у Вас гражданство?',
            'is_agree' => 'Ознакомлены с инструкцией по подаче документов?',
            'is_dlnr_ua' => 'Гражданин РФ, который до прибытия на территорию Российской Федерации проживал на территории ДНР, ЛНР или Украины',
            'current_edu_level' => 'Какой Ваш текущий уровень образования?',
            'category_id' => 'К какой категории граждан Вы относитесь?',
            'category' => 'Категория',
            'speciality_spo'=> 'Направление подготовки текущего уровня образования',
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
        if($this->category_id == CategoryStruct::TPGU_PROJECT){
            $level = DictCompetitiveGroup::find()->distinct()->select('edu_level')->onlyTpgu()->column();
            return $level;
        }

        return  $result;
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

    public function isOrphan()
    {
        return  $this->isExemptionDocument();
    }

    public function isExemptionDocument($exemptionId  = 2)
    {
        return  OtherDocument::find()->andWhere(['user_id'=>$this->user_id, 'exemption_id'=>$exemptionId])->exists();
    }


    public function onlyCse()
    {
        $condition = $this->current_edu_level == AnketaHelper::SCHOOL_TYPE_SCHOOL
            && (($this->citizenship_id == DictCountryHelper::RUSSIA) ||
                ($this->category_id == CategoryStruct::COMPATRIOT_COMPETITION ||
                in_array($this->citizenship_id, DictCountryHelper::TASHKENT_AGREEMENT)))
            && !$this->is_foreigner_edu_organization
            && !$this->is_dlnr_ua
            && !$this->isExemptionDocument(1);
        return $condition;

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

    public function getInsuranceCertificateUser()
    {
        return $this->hasMany(InsuranceCertificateUser::class, ['user_id' => 'user_id']);
    }

    public function getProfile()
    {
        return $this->hasOne(Profiles::class, ['user_id' => 'user_id']);
    }

    public function getUser() {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getFiles() {
       return $this->hasMany(File::class, ['user_id' => 'user_id']);
    }

    public function getUserDisciplineCseCt()
    {
        return $this->hasMany(UserDiscipline::class, ['user_id' => 'user_id'])
            ->andWhere(['type'=> [UserDiscipline::CSE, UserDiscipline::CT]]);
    }

    public function spoNpo()
    {
        return $this->current_edu_level == AnketaHelper::SCHOOL_TYPE_NPO || $this->current_edu_level == AnketaHelper::SCHOOL_TYPE_SPO;
    }

    public function onlySpo()
    {
        return $this->spoNpo() && !$this->is_foreigner_edu_organization;
    }
}
