<?php

namespace dod\helpers;

use api\providers\User;
use dod\models\DateDod;
use dod\models\Dod;
use dod\models\UserDod;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class DateDodHelper
{
    const TYPE_INTRAMURAL = 1;
    const TYPE_INTRAMURAL_LIVE_BROADCAST = 2;
    const TYPE_WEB = 3;
    const TYPE_REMOTE = 4;
    const TYPE_HYBRID = 5;
    const TYPE_REMOTE_EDU = 6;

    public static function listTypes(): array
    {
        return [
            self::TYPE_INTRAMURAL =>'очный тип',
            self::TYPE_INTRAMURAL_LIVE_BROADCAST =>'очный тип с прямой трансляцией',
            self::TYPE_WEB => 'вебинар',
            self::TYPE_REMOTE => 'дистанционный тип',
            self::TYPE_HYBRID =>'гибридный тип (очный и дистанционный)',
            self::TYPE_REMOTE_EDU => 'дистанционный для учебных организаций'
        ];
    }

    public static function listTypesId(): array
    {
        return [
            self::TYPE_INTRAMURAL_LIVE_BROADCAST,
            self::TYPE_WEB,
            self::TYPE_REMOTE,
            self::TYPE_HYBRID,
            self::TYPE_REMOTE_EDU
        ];
    }

    public static function typeName($key): string
    {
        return ArrayHelper::getValue(self::listTypes(), $key);
    }

    public static function maxDate($dateTime, $type, $dod_id): bool
    {
        $dateMax = DateDod::find()->type($type, $dod_id)->max('date_time');
        if ($type == self::TYPE_INTRAMURAL) {
            return true;
        }
        return $dateTime == $dateMax;
    }

    public static function linkOnline(DateDod $dod, $class) {
        return self::dodLink($dod, $class, "Онлайн-участие");
    }

    public static function linkRegister($link, $class) {
        return self::dodLinkRegister($class, $link, "Зарегистрироваться");
    }

    public static function dodDateNoActual(DateDod $dod, $class) {
         if ($dod->isTypeHybrid() || $dod->isTypeRemote()) {
             self::linkOnline($dod, $class);
         } elseif ($dod->isTypeIntramuralLiveBroadcast() || $dod->isTypeWeb() || $dod->isTypeRemoteEdu()) {
              return self::dodLink($dod, $class, "Онлайн-трансляция");
         }else {
              return self::dodLink($dod, $class, "Смотреть запись");
         }
    }

    public static function dodDateActualGuestAndUser(DateDod $dod, $class, $isUser)  {
        $link = [$isUser ? 'user-dod/registration' : 'registration-on-dod', 'id'=> $dod->id];
        if ($dod->isTypeHybrid())
            return self::linkRegister($link, $class).self::linkOnline($dod, $class);
        elseif ($dod->isTypeRemote()) {
            return self::linkOnline($dod, $class);
        }
        else {
            return self::linkRegister($link, $class);
    }
    }

    public static function dodDateActual(DateDod $dod, $class, $isUser)
    {
        if($isUser) {
            if($dod->isTypeIntramuralLiveBroadcast()) {
                return  self::dodLinkRegister($class, self::linkTypeIntramuralLiveBroadcast($dod, UserDodHelper::FORM_INTRAMURAL), '«Приду  на мероприятие»').
                    self::dodLinkRegister($class, self::linkTypeIntramuralLiveBroadcast($dod, UserDodHelper::FORM_LIVE_BROADCAST), '«Посмотрю прямую трансляцию»');
            }elseif($dod->isTypeRemoteEdu()) {
                $link = ['user-dod/registration-on-dod-remote-user', 'id'=> $dod->id];
                return self::linkRegister($link, $class);
            }
            return self::dodDateActualGuestAndUser($dod, $class, $isUser);
        }
        return self::dodDateActualGuestAndUser($dod, $class, $isUser);
    }

    public static function dodLink(DateDod $dod, $class, $name) {
        return Html::a($name, ['dod', 'id' => $dod->id], ['class' => $class]);
    }

    public static function dodDeleteLinks(DateDod $dod, UserDod $userDod, $class) {
        if ($dod->isTypeHybrid()) {
            return self::linkOnline($dod, $class).UserDodHelper::userDodDeleteLink($class, $userDod);
        }
        return UserDodHelper::userDodDeleteLink($class, $userDod);
    }

    public static function dodLinkRegister($class, $link, $name) {

        return Html::a($name, $link, ['class' => $class]);
    }

    private static function linkTypeIntramuralLiveBroadcast(DateDod $dod, $type)
    {
        return ['user-dod/registration', 'id' => $dod->id, 'type'=> $type];
    }
}