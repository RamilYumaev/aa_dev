<?php


namespace olympic\helpers;


use olympic\models\Olympic;
use yii\helpers\ArrayHelper;

class OlympicHelper
{
    const FOR_PUPLE = 1;
    const FOR_STUDENT = 2;
    const INTERUNIVERSITY = 3;

    const OCHNAYA_FORMA = 1;
    const ZAOCHNAYA_FORMA = 2;
    const OCHNO_ZAOCHNAYA_FORMA = 3;
    const ZAOCHNO_OCHO_ZAOCHNAYA = 4;
    const ZAOCHNO_ZAOCHNAYA = 5;

    const FIRST_LIST_POSITION = 1;
    const SECOND_LIST_POSITION = 2;
    const THIRD_LIST_POSITION = 3;
    const NULL_LIST_POSITION = null;

    const ONE_TOUR = 1;
    const TWO_TOUR = 2;
    const THREE_TOUR = 3;

    const TIME_FIX = 1;
    const TIME_REG = 2;

    const SHOW_WORK_YES = 1;
    const SHOW_WORK_NO = 2;

    const PREFILING_BAS = 0;
    const PREFILING_PRE = 1;

    const OLIMPIC_FILTER_BY_PREFILLING = 1;
    const OLIMPIC_FILTER_BY_CLASS = 2;
    const OLIMPIC_FILTER_BY_RECORD = 3;
    const OLIMPIC_FILTER_BY_FACULTY = 4;
    const OLIMPIC_FILTER_BY_DATE_START_FINISH = 5;
    const OLIMPIC_FILTER_BY_BACHELOR = 6;
    const OLIMPIC_FILTER_BY_MAGISTR = 7;
    const OLIMPIC_FILTER_BY_FILIALS = 8;
    const OLIMPIC_FILTER_BY_BACHELOR_PRE = 9;
    const OLIMPIC_FILTER_BY_MAGISTR_PRE = 10;
    const OLIMPIC_FILTER_BY_FILIALS_PRE = 11;
    const OLIMPIC_FILTER_BY_PAST = 12;
    const OLIMPIC_FILTER_BY_FIRST_POSITION = 13;

    const REG_STATUS = 0;
    const ZAOCH_FINISH = 1;
    const OCH_FINISH = 2;

    const APPELLATION = 3;
    const PRELIMINARY_FINISH  = 4;
    const NO_FINISH = 5;

    const COUNT_USER_OCH = 10;
    const COUNT_USER_ZAOCH = 25;

    const ACTIVE = 0;
    const DRAFT = 1;

    const USER_REWARDS = 40;
    const USER_REWARDS_GOLD = 10;


    const CERTIFICATE_YES = 1;

    public static function typeOfTimeDistanceTour()
    {
        return [
            '' => '',
            self::TIME_FIX => 'На выполнение заданий заочного (дистанционного) тура отводится фиксированное время',
            self::TIME_REG => 'Выполнить задания необходимо до завершения периода регистрации на настоящее Мероприятие',
        ];
    }

    public static function statusList()
    {
        return [
            self::ACTIVE => 'Активный',
            self::DRAFT => 'Неактивный',
        ];
    }

    public static function statusListValid()
    {
        return [
            self::ACTIVE, self::DRAFT
        ];
    }



    public static function typeOfTimeDistanceTourValid()
    {
        return ['', self::TIME_FIX, self::TIME_REG];
    }

    public static function numberOfTours()
    {
        return [
            '' => '',
            self::ONE_TOUR => '1 тур',
            self::TWO_TOUR => '2 тура',
            self::THREE_TOUR => '3 тура',
        ];
    }

    public static function numberOfToursValid()
    {
        return ['', self::ONE_TOUR, self::TWO_TOUR, self::THREE_TOUR];
    }

    public static function listPosition()
    {
        return [
            self::NULL_LIST_POSITION => 'Обычная позиция',
            self::FIRST_LIST_POSITION => 'Первая позиция',
            self::SECOND_LIST_POSITION => 'Вторая позиция',
            self::THIRD_LIST_POSITION => 'Третья позиция',
        ];
    }

    public static function listPositionValid()
    {
        return [self::NULL_LIST_POSITION, self::FIRST_LIST_POSITION, self::SECOND_LIST_POSITION,
            self::THIRD_LIST_POSITION];
    }

    public static function formOfPassage()
    {
        return [
            '' => '',
            self::OCHNAYA_FORMA => 'очная форма',
            self::ZAOCHNAYA_FORMA => 'заочная форма',
            self::OCHNO_ZAOCHNAYA_FORMA => 'заочная и очная формы',
            self::ZAOCHNO_OCHO_ZAOCHNAYA => 'заочно-очно-заочная форма',
            self::ZAOCHNO_ZAOCHNAYA => 'заочно-заочная форма',
        ];
    }

    public static function formOfPassageValid()
    {
        return ['', self::OCHNAYA_FORMA, self::ZAOCHNAYA_FORMA, self::OCHNO_ZAOCHNAYA_FORMA,
            self::ZAOCHNO_OCHO_ZAOCHNAYA, self::ZAOCHNO_ZAOCHNAYA];
    }

    public static function levelOlimp()
    {
        return [
            '' => '',
            self::FOR_PUPLE => 'Для школьников',
            self::FOR_STUDENT => 'Для студентов',
            self::INTERUNIVERSITY => 'Межрегиональная',
        ];
    }

    public static function levelOlimpValid()
    {
        return ['', self::FOR_PUPLE, self::FOR_STUDENT, self::INTERUNIVERSITY];
    }

    public static function showingWork()
    {
        return [
            '' => '',
            self::SHOW_WORK_YES => 'предусмотрены',
            self::SHOW_WORK_NO => 'не предусмотрены',
        ];
    }

    public static function showingWorkValid()
    {
        return ['', self::SHOW_WORK_YES, self::SHOW_WORK_NO];
    }

    public static function prefilling()
    {
        return [
            self::PREFILING_BAS => 'Опубликовано',
            self::PREFILING_PRE => 'Черновик',
        ];
    }

    public static function prefillingValid()
    {
        return [self::PREFILING_BAS, self::PREFILING_PRE];
    }

    public static function typeOfTimeDistanceTourName($key)
    {
        return ArrayHelper::getValue(self::typeOfTimeDistanceTour(), $key);
    }

    public static function numberOfToursName($key)
    {
        return ArrayHelper::getValue(self::numberOfTours(), $key);
    }

    public static function statusName($key)
    {
        return ArrayHelper::getValue(self::statusList(), $key);
    }

    public static function listPositionName($key)
    {
        return ArrayHelper::getValue(self::listPosition(), $key);
    }

    public static function formOfPassageName($key)
    {
        return ArrayHelper::getValue(self::formOfPassage(), $key);
    }

    public static function levelOlimpName($key)
    {
        return ArrayHelper::getValue(self::levelOlimp(), $key);
    }

    public static function showingWorkName($key)
    {
        return ArrayHelper::getValue(self::showingWork(), $key);
    }

    public static function prefillingName($key)
    {
        return ArrayHelper::getValue(self::prefilling(), $key);
    }

    public static function olympicList(): array
    {
        return ArrayHelper::map(Olympic::find()->all(), "id", 'name');
    }

    public static function olympicManagerList()
    {
        return Olympic::find()->manager(\Yii::$app->user->identity->getId())->select('id')->column();
    }

    public static function olympicName($key): string
    {
        return ArrayHelper::getValue(self::olympicList(), $key);
    }
}