<?php

namespace modules\entrant\helpers;
use modules\entrant\models\Anketa;
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
            self::TYPE_MAIL => "По почте",
            self::TYPE_ONLINE => "Онлайн",
            self::TYPE_VISIT => "Личный визит",
            self::TYPE_ECP => "Онлайн с электронной подписью",
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
            self::TYPE_MAIL => 'btn btn-info',
            self::TYPE_ONLINE => 'btn btn-success',
            self::TYPE_VISIT => 'btn btn-primary',
            self::TYPE_ECP => 'btn btn-warning',
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
            AddressHelper::isExits($user_id) &&
            PassportDataHelper::isExits($user_id) &&
            LanguageHelper::isExits($user_id) &&
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

    public static function isCorrectBlocks() : bool
    {
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