<?php
namespace common\sending\helpers;
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

}