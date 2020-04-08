<?php

namespace modules\entrant\helpers;


use modules\entrant\models\Anketa;
use olympic\helpers\auth\ProfileHelper;

class PostDocumentHelper
{
    private static function common($user_id)
    {
        return UserCgHelper::findUser($user_id) &&
            AddressHelper::isExits($user_id) &&
            PassportDataHelper::isExits($user_id) &&
           // LanguageHelper::isExits($user_id) &&
            ProfileHelper::isDataNoEmpty($user_id) &&
            DocumentEducationHelper::isDataNoEmpty($user_id);
    }

    private static function exemption($user_id)
    {
        return OtherDocumentHelper::isExitsExemption($user_id) && self::common($user_id);
    }

    private static function agreement($user_id)
    {
        return AgreementHelper::isExits($user_id) && self::common($user_id);
    }

    public static function compatriot($user_id)
    {
        return OtherDocumentHelper::isExitsPatriot($user_id) && self::common($user_id);
    }

    private static function userId()
    {
        return \Yii::$app->user->identity->getId();
    }

    private static function userAnketa(): ?Anketa
    {
        return \Yii::$app->user->identity->anketa();
    }

    public static function  isCorrectBlocks() {
        if(self::userAnketa()->isPatriot()) {
            return  self::compatriot(self::userId());
        }elseif (self::userAnketa()->isExemption()) {
            return self::exemption(self::userId());
        }elseif (self::userAnketa()->isAgreement()){
            return self::agreement(self::userId());
        }else {
            return self::common(self::userId());
        }
    }

}