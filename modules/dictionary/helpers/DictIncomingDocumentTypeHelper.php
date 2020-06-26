<?php
namespace modules\dictionary\helpers;

use dictionary\helpers\DictCountryHelper;
use modules\dictionary\models\DictIncomingDocumentType;
use modules\entrant\helpers\AnketaHelper;
use yii\helpers\ArrayHelper;

class DictIncomingDocumentTypeHelper
{
    const TYPE_OTHER = null;
    const TYPE_EDUCATION = 1;
    const TYPE_PASSPORT = 2;
    const TYPE_MEDICINE= 3;

    const TYPE_EDUCATION_VUZ= 4;
    const TYPE_EDUCATION_PHOTO= 5;
    const TYPE_DIPLOMA= 6;

    const ID_PHOTO= 45;
    const ID_MEDICINE= 29;

    const ID_BIRTH_DOCUMENT = 4;
    const ID_BIRTH_FOREIGNER_DOCUMENT = 8;

    const ID_PASSPORT_RUSSIA = 1;
    const ID_NAME_WEDDING = 49;
    const ID_NAME_WEDDING_DOC = 51;
    const ID_NAME_UPDATE = 50;
    const ID_PATRIOT_DOC = 43;


    const ID_AFTER_DOC = 30;

    public static function listType($type)
    {
        return ArrayHelper::map(self::find()->type($type)->all(), 'id', 'name');
    }

    public static function listId($idIa)
    {
        return ArrayHelper::map(self::find()->ids(self::iADoc($idIa))->all(), 'id', 'name');
    }
    

    public static function listPassport($country)
    {
        $anketa = \Yii::$app->user->identity->anketa();
        if($anketa->isOrphan())
        {
            $query=  self::find()->type(self::TYPE_PASSPORT)->andWhere(['not in', 'id', [self::ID_BIRTH_DOCUMENT]])
                ->select('name')->indexBy('id')->column();
        }else{
            $query=  self::find()->type(self::TYPE_PASSPORT)->select('name')->indexBy('id')->column();
        }
        if($country == DictCountryHelper::RUSSIA) {
            $delete_keys = [3, 16, 8, 7, 11, 14, 15];
        }else {
            $delete_keys = [1,4, 2,5,6, 10,12];
        }
        return array_diff_key($query, array_flip($delete_keys));
    }

    public static function listEducation($type)
    {
        $array = self::find()->type(self::TYPE_EDUCATION)->select('name')->indexBy('id')->column();
        if($type == AnketaHelper::SCHOOL_TYPE_SCHOOL_9) {
            $delete_keys = [18,19,20,21,22,23,26,27];
        }elseif($type == AnketaHelper::SCHOOL_TYPE_SCHOOL) {
            $delete_keys = [19,20,21,22,23,25,26,27];
        }elseif($type == AnketaHelper::SCHOOL_TYPE_NPO) {
            $delete_keys = [18,19,20,22,23,25,26,27];
        }elseif($type == AnketaHelper::SCHOOL_TYPE_SPO) {
            $delete_keys = [18,19,21,22,23,25,26,27];
        }elseif($type == AnketaHelper::SCHOOL_TYPE_BACHELOR) {
            $delete_keys = [18,20,21,22,23,25,26,27];
        }elseif($type == AnketaHelper::SCHOOL_TYPE_SPECIALIST) {
            $delete_keys = [18,20,21,22,23,25,26,27];
        }elseif($type == AnketaHelper::SCHOOL_TYPE_MAGISTER) {
            $delete_keys = [18,20,21,22,23,25,26,27];
        }elseif($type == AnketaHelper::SCHOOL_TYPE_DIPLOMA_SPECIALIST) {
            $delete_keys = [18,20,21,22,23,25,26,27];
        }elseif($type == AnketaHelper::SCHOOL_TYPE_PHD) {
            $delete_keys = [18,19,20,21,22,23,25,27];
        }
        else {
            $delete_keys = [18,19,20,21,22,23,25,26];
        }

        return array_diff_key($array, array_flip($delete_keys));
    }

    public static function rangePassport($country)
    {
        return array_values(array_flip(self::listPassport($country)));
    }

    public static function rangeEducation($type)
    {
        return array_values(array_flip(self::listEducation($type)));
    }


    public static function rangeType($type)
    {
        return self::find()->type($type)->select('id')->column();
    }

    public static function rangeIds($idIa)
    {
        return self::find()->ids(self::iADoc($idIa))->select('id')->column();
    }

    private static function find()
    {
        return DictIncomingDocumentType::find();
    }

    private static function iADoc($idIa) {
        return DictIndividualAchievementDocumentHelper::listDocument($idIa);
    }

    public static function typeName($type, $key): ? string
    {
        return ArrayHelper::getValue(self::listType($type), $key);
    }






}