<?php
namespace common\sending\helpers;
use common\auth\models\User;
use common\sending\models\DictSendingTemplate;
use common\sending\models\Sending;
use olympic\helpers\auth\ProfileHelper;
use olympic\helpers\DiplomaHelper;
use olympic\helpers\OlympicHelper;
use olympic\helpers\PersonalPresenceAttemptHelper;
use olympic\models\OlimpicList;
use yii\helpers\ArrayHelper;

class SendingHelper
{
    /**
     * {@inheritdoc}
     */
    const WEITING_MODERATION = 0;
    const CONFIRM = 1;
    const FINISH_SENDING = 2;

    const USER_SEND_FOR_PERSONAL_TOUR_MEMBER = 1;
    const USER_SEND_FOR_WINNER = 2;

    const TYPE_TEXT = 1;
    const TYPE_HTML = 2;

    public static function typeTemplateList()
    {
        return [
            ''=>'',
            self::USER_SEND_FOR_PERSONAL_TOUR_MEMBER => 'Приглашение на очный тур',
            self::USER_SEND_FOR_WINNER => 'Рассылка сертификатов победителям',
        ];
    }


    public static function typeSendingList()
    {
        return [
            self::WEITING_MODERATION => 'Ожидает проверки',
            self::CONFIRM => 'Одобрена',
            self::FINISH_SENDING => 'Завершена',
        ];
    }

    public static function typeSendingName($key): string
    {
        return ArrayHelper::getValue(self::typeSendingList(), $key);
    }

    public static function templateSendingName($key): ?string
    {
        return ArrayHelper::getValue(self::typeTemplateList(), $key);
    }

    public static function templatesLabel()
    {
        return [
            '{имя отчество получателя}',
            '{название олимпиады в родительном падеже}',//
            '{дата и время очного тура олимпиады}',//
            '{адрес проведения очного тура}', //
            '{Ф.И.О. председателя олимпиады}', //
            '{1-е место, 2-е место, 3-е место}',
            '{ссылка на диплом}',
            '{ссылка на приглашение}',
        ];
    }

    public static function textOlympicEmail(User $user, OlimpicList $olympic, $hash, $type,
                                            DictSendingTemplate $sendingTemplate, $type_sending, $gratitude_id) {
        $array = $olympic->replaceLabelsFromSending();
        array_unshift($array, ProfileHelper::profileName($user->id));
        $template = $type == self::TYPE_HTML ?  $sendingTemplate->html : $sendingTemplate->text;
        switch ($type_sending) {
            case SendingDeliveryStatusHelper::TYPE_SEND_DIPLOMA :
                $diploma = DiplomaHelper::userDiploma($user->id, $olympic->id);
                $reward = PersonalPresenceAttemptHelper::nameOfPlacesValueOne($diploma->reward_status_id);
                array_push($array, $reward ?? "",  \yii\helpers\Url::to('@frontendInfo/diploma?id='.$diploma->id.'&hash='.$hash, true), "");
                break;
            case SendingDeliveryStatusHelper::TYPE_SEND_PRELIMINARY:
                $numTour = $olympic->isFormOfPassageDistantInternal() ? OlympicHelper::OCH_FINISH : null;
                $urlString = '@frontendInfo/print/olimp-result?olympic_id='.$olympic->id.'&numTour='.$numTour.'&hash='.$hash;
                array_push($array, "", "",  \yii\helpers\Url::to($urlString, true));
                break;
            case SendingDeliveryStatusHelper::TYPE_SEND_GRATITUDE :
                array_push($array,  "",  \yii\helpers\Url::to('@frontendInfo/gratitude?id='.$gratitude_id.'&hash='.$hash, true), "");
                break;
            default:
                array_push($array, "", "",  \yii\helpers\Url::to('@frontendInfo/invitation?hash='.$hash, true));
                break;
        }
        return str_replace(self::templatesLabel(), $array, $template);
    }

    public static function sendingData($type, $typeSending, $value)
    {
        return Sending::find()->type($type)->typeSending($typeSending)->value($value)->statusSending(self::FINISH_SENDING)->exists();
    }


}