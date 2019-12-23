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

    public static function textOlympic () {
       return 'Здравствуйте, {имя отчество получателя}!
        Приглашаем Вас принять участие в очном туре {название олимпиады в родительном падеже} {дата и время очного тура олимпиады}, 
        который будет проходить по адресу: {адрес проведения очного тура}. \r\n​
        Ваше персональное приглашение доступно по ссылке: {ссылка на приглашение}\r\n\r\n 
        С уважением, \r\nпредседатель оргкомитета {название олимпиады в родительном падеже}\r\n {Ф.И.О. председателя олимпиады}';
    }

    public static function htmlOlympic () {
        return '<h1>Здравствуйте,&nbsp;{имя отчество получателя}!</h1>
        <p>Приглашаем Вас принять участие в очном туре {дата и время очного тура олимпиады}, который будет проходить по адресу: {адрес проведения очного тура}.<br />
        Ваше персональное приглашение доступно по ссылке: <a href="{ссылка на приглашение}">{ссылка на приглашение}</a></p>
        <p style="text-align:right">С уважением,<br />
        председатель оргкомитета {название олимпиады в родительном падеже}<br />
        {Ф.И.О. председателя олимпиады}</p>';
    }
}