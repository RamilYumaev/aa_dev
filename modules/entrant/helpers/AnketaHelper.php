<?php

namespace modules\entrant\helpers;


class AnketaHelper
{
    const SCHOOL_TYPE_SCHOOL = 1;
    const SCHOOL_TYPE_SPO = 2;
    const SCHOOL_TYPE_BACHELOR = 3;
    const SCHOOL_TYPE_SPECIALIST = 4;
    const SCHOOL_TYPE_MAGISTER = 5;
    const SCHOOL_TYPE_DIPLOMA_SPECIALIST = 6;
    const SCHOOL_TYPE_PHD = 7;
    const SCHOOL_TYPE_DOCTOR_SCIENCES = 8;
    const SCHOOL_TYPE_NPO = 9;
    const SCHOOL_TYPE_SCHOOL_9 = 10;

    const EC_RF_COMMON_BASIS = 1;
    const EC_IN_COMPATRIOT = 2;
    const EC_IN = 3;
    const EC_KVOTA = 4;
    const EC_CELEVIK = 5;
    const EC_PARALLEL = 6;



    public static function currentEducationLevel()
    {
        return [
            self::SCHOOL_TYPE_SCHOOL_9 => 'Основное общее образование (Аттестат за 9 классов)',
            self::SCHOOL_TYPE_SCHOOL => 'Среднее общее образование (Аттестат за 11 классов)',
            self::SCHOOL_TYPE_NPO => 'Начальное профессиональное образование (Диплом НПО)',
            self::SCHOOL_TYPE_SPO => 'Среднее профессиональное образование (Диплом СПО)',
            self::SCHOOL_TYPE_BACHELOR => 'Бакалавриат (Диплом бакалавра)',
            self::SCHOOL_TYPE_SPECIALIST => 'Высшее образование (Диплом специалиста)*',
            self::SCHOOL_TYPE_MAGISTER => 'Высшее образование (Диплом магистра)',
            self::SCHOOL_TYPE_DIPLOMA_SPECIALIST => 'Высшее образование (Дипломированный специалист)',
            self::SCHOOL_TYPE_PHD => 'Высшее образование (Диплом кандидата наук или аспиранта)',
            self::SCHOOL_TYPE_DOCTOR_SCIENCES => 'Высшее образование (Диплом доктора наук)',
        ];
    }

    public static function entrantCategory()
    {
        return [
            self::EC_RF_COMMON_BASIS => 'Гражданин РФ, поступающий на общих основаниях',
            self::EC_IN_COMPATRIOT => 'Иностранный гражданин, относящийся к категории соотечественников **',
            self::EC_IN => 'Иностранные граждане, поступающие на платной основе',
            self::EC_KVOTA => 'Гражданин РФ, относящийся к льготной категории***',
            self::EC_CELEVIK => 'Гражданин РФ, имеющий целевое направление',
            self::EC_PARALLEL => 'Граждане, обучающиеся в вузе в настоящий момент',


        ];
    }

}