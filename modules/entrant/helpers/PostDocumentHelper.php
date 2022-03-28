<?php

namespace modules\entrant\helpers;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DisciplineCompetitiveGroup;
use frontend\widgets\competitive\ButtonWidget;
use modules\entrant\models\Anketa;
use modules\entrant\models\UserDiscipline;
use olympic\helpers\auth\ProfileHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class PostDocumentHelper
{
    const TYPE_MAIL = 1;
    const TYPE_ONLINE = 2;
    const TYPE_VISIT = 3;
    const TYPE_ECP = 4;

    public static function submittedList() {
        return [
         //   self::TYPE_MAIL => "По почте",
            self::TYPE_ONLINE => "Загрузка документов",
           // self::TYPE_VISIT => "Личный визит",
           // self::TYPE_ECP => "Онлайн с электронной подписью",
        ];
    }

    public static function submittedListUrl() {
        return [
            self::TYPE_MAIL => ['post-document/mail'],
            self::TYPE_ONLINE => ['post-document/online'],
            self::TYPE_VISIT => ['post-document/visit'],
            self::TYPE_ECP => ['post-document/ecp'],
        ];
    }

    public static function submittedLisClass() {
        return [
            self::TYPE_MAIL => 'btn btn-lg btn-info',
            self::TYPE_ONLINE => 'btn btn-lg btn-warning',
            self::TYPE_VISIT => 'btn btn-lg btn-primary',
            self::TYPE_ECP => 'btn btn-lg btn-success',
        ];
    }

    public static function value(array $array, $key)
    {
       return ArrayHelper::getValue($array, $key);
    }

    public static function link($key, $link = null) {
        return Html::a(self::value(self::submittedList(), $key), $link ?? self::value(self::submittedListUrl(), $key),
                        ['class'=> self::value(self::submittedLisClass(), $key), 'data'=> ['method' => 'post']]);
    }

    private static function common($user_id)
    {
        return UserCgHelper::findUser($user_id) &&
            self::addressRequired($user_id) &&
            PassportDataHelper::isExits($user_id) &&
            LanguageHelper::isExits($user_id) &&
            ProfileHelper::isDataNoEmpty($user_id) &&
            DocumentEducationHelper::isDataNoEmpty($user_id) &&
            UserDisciplineHelper::isCorrect($user_id) &&
            AdditionalInformationHelper::isExits($user_id) &&
            AdditionalInformationHelper::isSpoMark($user_id) &&
            self::medicine($user_id) &&
            self::exemptionNoParent($user_id) &&
            self::name($user_id) &&
            self::fioLatin($user_id);
    }

    private static function exemption($user_id)
    {
        return OtherDocumentHelper::isExitsExemption($user_id, [1,2,3]) && self::common($user_id);
    }

    public static function exemptionNoParent($user_id): bool
    {
        if (OtherDocumentHelper::isExitsExemption($user_id, 2)) {
            return PassportDataHelper::isDocumentBirthday($user_id);
        }
        return true;
    }

    private static function agreement($user_id)
    {
        return AgreementHelper::isExits($user_id) && self::common($user_id);
    }

    private static function  addressRequired($user_id) {
        return self::userAnketa($user_id)->isNoRequired() ? true  : AddressHelper::isExits($user_id);
    }

    private static function fioLatin($user_id)
    {
        return !self::userAnketa($user_id)->isRussia() ? FioLatinHelper::isExits($user_id) : true;
    }


    public static function compatriot($user_id)
    {
        return OtherDocumentHelper::isExitsPatriot($user_id) && self::common($user_id);
    }

    public static function without($user_id)
    {
        return OtherDocumentHelper::isWithout($user_id) && self::common($user_id);
    }

    public static function medicine($user_id) {
//        if(UserCgHelper::userMedicine($user_id)) {
//            return OtherDocumentHelper::isExitsMedicine($user_id);
//        }
        return true;
    }

    public static function name($user_id) {
        if(DocumentEducationHelper::isNameSurname($user_id)) {
            return OtherDocumentHelper::isExitsUpdateName($user_id);
        }
        return true;
    }

    private static function isSpoCorrect($userId)
    {
        foreach (DictCompetitiveGroupHelper::groupByExamsSpo($userId) as $key => $value) {
            if(!UserDiscipline::find()->discipline($key)->exists()) {
                return false;
            }
            if(!UserDisciplineHelper::isSpoCorrect($userId, $key)) {
                return false;
            }
        }
        return true;
    }

    private static function userAnketa($userId): ?Anketa
    {
        return Anketa::findOne(['user_id'=> $userId]);
    }

    public static function isCorrectBlocks($userId) : bool
    {
        if(self::userAnketa($userId)->isPatriot()) {
            return  self::compatriot($userId);
        }elseif (self::userAnketa($userId)->isWithOitCompetition()) {
            return self::without($userId);
        }elseif (self::userAnketa($userId)->onlySpo()) {
            return self::common($userId) && self::isSpoCorrect($userId);
        }
        else {
            return self::common($userId);
        }
    }
}