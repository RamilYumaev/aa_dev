<?php

namespace modules\entrant\helpers;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictFacultyHelper;
use modules\entrant\models\Agreement;
use modules\entrant\readRepositories\AgreementReadRepository;
use yii\helpers\ArrayHelper;

class AgreementHelper
{
    const STATUS_NEW = 0;
    const STATUS_VIEW = 1;
    const STATUS_ACCEPTED = 2;
    const STATUS_NO_ACCEPTED = 3;

    const FIO_NOMINATIVE = 1;
    const FIO_GENITIVE = 2;
    const POSITION_NOMINATIVE = 3;
    const POSITION_GENITIVE = 4;
    const PROCURATION = 5;
    const FIO_SHORT = 6;


    public static function statusList()
    {
        return [
            self::STATUS_NEW => "Новое",
            self::STATUS_ACCEPTED => "Принято",
            self::STATUS_NO_ACCEPTED => "Не принято",
            self::STATUS_VIEW => "Взято в работу"];
    }

    public static function statusName($key)
    {
        return ArrayHelper::getValue(self::statusList(), $key);
    }


    public static function colorList()
    {
        return [
            self::STATUS_NEW => "warning",
            self::STATUS_ACCEPTED => "success",
            self::STATUS_NO_ACCEPTED => "danger",
            self::STATUS_VIEW => "info"];
    }

    public static function colorName($key)
    {
        return ArrayHelper::getValue(self::colorList(), $key);
    }

    public static function isExits($user_id): bool
    {
        return Agreement::find()->andWhere(['user_id' => $user_id])->exists();
    }

    public static function data($faculty, $collegeStatus = false)
    {
        $universityChoice = DictFacultyHelper::getKeyFacultySetting($faculty);
        $universityChoice = $universityChoice == DictFacultyHelper::COLLAGE ? AnketaHelper::HEAD_UNIVERSITY : $universityChoice;
        return [
            'accidence' => self::accidence()[$universityChoice],
            'positionsGenitive' => self::positionsGenitive($collegeStatus)[$universityChoice],
            'positionNominative' => self::positionNominative($collegeStatus)[$universityChoice],
            'directorNameShort' => self::directorNameShort($collegeStatus)[$universityChoice],
            'directorNameGenitiveFull' => self::directorNameGenitiveFull($collegeStatus)[$universityChoice],
            'directorNameNominativeFull' => self::directorNameNominativeFull($collegeStatus)[$universityChoice],
            'procuration' => self::procuration($collegeStatus)[$universityChoice],

        ];
    }

    public static function accidence()
    {
        return [
            AnketaHelper::HEAD_UNIVERSITY => "Федеральное государственное 
                                                бюджетное образовательное
                                                учреждение высшего
                                                образования «Московский
                                                педагогический государственный
                                                университет»<br/>
                                                Место нахождения: 119435, г. Москва,
                                                 ул. Малая Пироговская, д. 1, стр.1<br/>
                                                тел./факс: 8-499-245-03-10<br/>
                                                e-mail: mail@mpgu.su<br/>
                                                ОГРН 1027700215344<br/>
                                                ИНН 7704077771<br/>
                                                КПП 770401001<br/><br/>
                                                Банковские реквизиты:<br/>
                                                УФК по г. Москве (МПГУ л/с 20736У53790)<br/>
                                                ГУ БАНКА РОССИИ ПО ЦФО//УФК ПО Г. МОСКВЕ г. Москва<br/>
                                                БИК 004525988<br/>
                                                Казначейский счет 03214643000000017300<br/>
                                                ОКТМО 45383000<br/>
                                                КБК 00000000000000000130 - за оказание платных услуг",
            AnketaHelper::ANAPA_BRANCH => "Федеральное государственное бюджетное образовательное учреждение 
                                           высшего образования «Московский педагогический государственный университет» <br/> 
                                                Место нахождения: 119991, г. Москва, ул. Малая Пироговская, д. 1, стр.1<br/>
                                                Адрес (место нахождения) филиала: 353410, Краснодарский край, г. Анапа, ул. Астраханская, д.88<br/>
                                                тел.: 8 (86133) 5-62-87,  8 (86133) 4-26-76
                                                e-mail: f.anapa@mpgu.su<br/>
                                                ОГРН 1027700215344 ИНН 7704077771<br/>
                                                КПП 230143001<br/>
                                                Банковские реквизиты:<br/>
                                                ИНН – 7704077771<br/>
                                                ОГРН – 1027700215344<br/>
                                                Наименование банка – ЮЖНОЕ ГУ БАНКА РОССИИ //УФК по Краснодарскому краю г. Краснодар (АФ МПГУ л/с 20186В01260)<br/>
                                                Казначейский счет - 03214643000000011800<br/>
                                                Единый казначейский счет- 40102810945370000010<br/>
                                                БИК – 010349101<br/>
                                                КБК 00000000000000000130 – за оказание платных услуг<br/>
                                                ОКТМО 03703000",
            AnketaHelper::POKROV_BRANCH => "Федеральное государственное бюджетное образовательное учреждение высшего 
                                                образования «Московский педагогический государственный университет»<br/>  
                                                Место нахождения: 119991, г. Москва, ул. Малая Пироговская, д. 1, стр.1<br/>

                                                Адрес (место нахождения) филиала: 601120, Владимирская область, г. Покров, Спортивный проезд, д.2<br/>
                                                тел./факс: 8 (49243) 6-14-35, 8 (49243) 6-15-13<br/>
                                                e-mail: f_pokrov@mpgu.su<br/>
                                                ОГРН 1027700215344<br/>
                                                ИНН 7704077771<br/>
                                                КПП 332143001<br/>
                                                Банковские реквизиты:<br/>
                                                ИНН – 7704077771<br/>
                                                ОГРН – 1027700215344<br/>
                                                КБК – 00000000000000000130 - за оказание платных услуг<br/>
                                                Наименование банка – УФК по Владимирской области (Покровский филиал МПГУ л/с 20286В01340)<br/>
                                                Казначейский счёт – 03214643000000012800<br/>
                                                Единый казначейский счет – 40102810945370000020<br/>
                                                КБК 00000000000000000130 – за оказание платных услуг<br/>
                                                БИК – 011708377<br/>
                                                л/с - УФК по Владимирской области (Покровский филиал МПГУ л/с 20286В01340)<br/>
                                                ОКТМО 17646120<br/>
                                                КБК 00000000000000000130 – за оказание платных услуг 
                                                ",
            AnketaHelper::STAVROPOL_BRANCH => "Федеральное государственное бюджетное образовательное учреждение высшего 
                                                образования «Московский педагогический государственный университет»<br/> 
                                            Место нахождения: 119991, г. Москва, ул. Малая Пироговская, д. 1, стр.1<br/>
                                            Адрес (место нахождения) филиала: 355042, Ставропольский край, г. Ставрополь, 
                                            ул. Доваторцев, 66Г<br/>
                                            тел./факс: 8(8652)52-16-88<br/>
                                            e-mail: f_stavropol@mpgu.su<br/>
                                            ОГРН 1027700215344<br/>
                                            ИНН 7704077771<br/>
                                            КПП 263543001<br/>
                                            Банковские реквизиты: <br/>
                                            ИНН 7704077771<br/>
                                            ОГРН 1027700215344<br/>
                                            КБК 00000000000000000130 – за оказание платных услуг<br/>
                                            Наименование банка – ОТДЕЛЕНИЕ СТАВРОПОЛЬ БАНКА РОССИИ//УФК по Ставропольскому  краю г. Ставрополь.<br/>
                                            Банковский счет 03214643000000012100<br/>
                                            ЕКС (единый казначейский счет) 40102810345370000013<br/>
                                            БИК – 010702101<br/>
                                            Наименование получателя - УФК по Ставропольскому краю (2133 Ставропольский филиал МПГУ л/с 20216Э35050)<br/>
                                            ОКТМО – 07701000<br/>
                                            КБК 00000000000000000130 – за оказание платных услуг",
            AnketaHelper::DERBENT_BRANCH => "Федеральное государственное бюджетное образовательное учреждение высшего 
                                                образования «Московский педагогический государственный университет»<br/>  
                                            Место нахождения: 119991, г. Москва, ул. Малая Пироговская, д. 1, стр.1<br/>
                                            Адрес (место нахождения) филиала: 368600, Республика Дагестан, г. Дербент, ул. Буйнакского, д.18<br/>
                                            тел./факс: 8 (240) 4-05-50<br/>
                                            e-mail: f_derbent@mpgu.su<br/>
                                            ОГРН 1027700215344<br/>
                                            ИНН 7704077771<br/>
                                            КПП 054243001<br/>
                                            Банковские реквизиты:<br/> 
                                            ИНН – 7704077771<br/>
                                            ОГРН – 1027700215344<br/>
                                            КБК – 00000000000000000130 - за оказание платных услуг<br/>
                                            Наименование банка – УФК по Республике Дагестан<br/>
                                            Казначейский счёт – 03214643000000010300<br/>
                                            Единый казначейский счёт – 40102810945370000069<br/>
                                            КБК 00000000000000000130 – за оказание платных услуг<br/>
                                            БИК – 018209001<br/>
                                            л/с – УФК по Республике Дагестан отдел №2 (Дербентский филиал МПГУ л/с 20036Э36740)<br/>
                                            ОКТМО 82710000<br/>
                                            КБК 00000000000000000130 – за оказание платных услуг 
                                            ",
            AnketaHelper::SERGIEV_POSAD_BRANCH => "Федеральное государственное бюджетное образовательное учреждение 
                                            высшего образования «Московский педагогический государственный университет»<br/>  
                                            Место нахождения: 119991, г. Москва, ул. Малая Пироговская, д. 1, стр.1<br/>
                                            Адрес (место нахождения) филиала: 141315, Московская область, г. Сергиев 
                                            Посад, ул. Разина д.1-А<br/>
                                            тел./факс: 8(496) 547-24-64<br/>
                                            e-mail: f_sergiev-posad@mpgu.su<br/>
                                            ОГРН 1027700215344<br/>
                                            ИНН 7704077771<br/>
                                            КПП 504243001<br/>
                                            Банковские реквизиты: <br/>
                                            Наименование банка – ГУ Банка России по ЦФО г.Москва 35<br/>
                                            БИК – 044525000<br/>
                                            р/с – 40501810545252000104<br/>
                                            ОКТМО – 46728000<br/>
                                            КБК 00000000000000000130 – за оказание платных услуг
                                            ",
            DictFacultyHelper::CHERNOHOVSK_BRANCH => "Федеральное государственное бюджетное образовательное 
                                                    учреждение высшего образования «Московский педагогический государственный университет»
                                                    Место нахождения: 119435, г. Москва, ул. Малая Пироговская, д. 1, стр.1 <br />
                                                    Адрес (место нахождения) филиала: 238158, Калининградская область,
                                                     г. Черняховск, пер. Суворова, д. 2  <br >
                                                    тел./факс: 8 (40141) 3-37-20<br />
                                                    e-mail: f_chernyakhovsk@mpgu.su  <br />
                                                    ОГРН 1027700215344  <br />
                                                    ИНН 7704077771  <br />
                                                    КПП 391443001 <br />
                                                    Банковские реквизиты:
                                                    ИНН 7704077771 <br />
                                                    КПП 391443001 <br />
                                                    Получатель: УФК по Калининградской области (филиал МПГУ в г. Черняховске, л/с 20356Ы94310)  <br />
                                                    Банк: ОТДЕЛЕНИЕ КАЛИНИНГРАД БАНКА РОССИИ//УФК по Калининградской области, г. Калининград <br />
                                                    БИК банка: 012748051  <br />
                                                    р/с 03214643000000013500 <br />
                                                    кор/с 40102810545370000028 <br />
                                                    ОКТМО 27539000<br />
                                                    КБК 00000000000000000130 – за оказание платных услуг",
        ];
    }

    public static function positionsGenitive($collegeStatus = false)
    {
        return [
            AnketaHelper::HEAD_UNIVERSITY => self::collegeVuzSwitcher($collegeStatus, self::POSITION_GENITIVE),
            AnketaHelper::ANAPA_BRANCH => 'директора Анапского филиала',
            AnketaHelper::POKROV_BRANCH => 'директора Покровского филиала',
            AnketaHelper::STAVROPOL_BRANCH => 'директора Ставропольского филиала',
            AnketaHelper::DERBENT_BRANCH => 'директора Дербентского филиала',
            AnketaHelper::SERGIEV_POSAD_BRANCH => 'директора Сергиево-Посадского филиала',
            DictFacultyHelper::CHERNOHOVSK_BRANCH => 'и.о. директора филиала МПГУ в г. Черняховске',
        ];
    }

    public static function positionNominative($collegeStatus = false)
    {
        return [
            AnketaHelper::HEAD_UNIVERSITY => self::collegeVuzSwitcher($collegeStatus, self::POSITION_NOMINATIVE),
            AnketaHelper::ANAPA_BRANCH => 'Директор Анапского филиала',
            AnketaHelper::POKROV_BRANCH => 'Директор Покровского филиала',
            AnketaHelper::STAVROPOL_BRANCH => 'Директор Ставропольского филиала',
            AnketaHelper::DERBENT_BRANCH => 'Директор Дербентского филиала',
            AnketaHelper::SERGIEV_POSAD_BRANCH => 'Директор Сергиево-Посадского филиала',
            DictFacultyHelper::CHERNOHOVSK_BRANCH => 'Исполняющий обязанности директора филиала МПГУ в г. Черняховске',
        ];
    }

    public static function directorNameShort($collegeStatus = false)
    {
        return [
            AnketaHelper::HEAD_UNIVERSITY => self::collegeVuzSwitcher($collegeStatus, self::FIO_SHORT),
            AnketaHelper::ANAPA_BRANCH => 'Е.А. Некрасова',
            AnketaHelper::POKROV_BRANCH => 'Л.В. Бойченко',
            AnketaHelper::STAVROPOL_BRANCH => 'Н.Н. Сотникова',
            AnketaHelper::DERBENT_BRANCH => 'Р.Д. Гусейнов',
            AnketaHelper::SERGIEV_POSAD_BRANCH => 'В.С. Морозова',
            DictFacultyHelper::CHERNOHOVSK_BRANCH => 'В.В. Мищенко',
        ];
    }

    public static function directorNameGenitiveFull($collegeStatus = false)
    {
        return [
            AnketaHelper::HEAD_UNIVERSITY => self::collegeVuzSwitcher($collegeStatus, self::FIO_GENITIVE),
            AnketaHelper::ANAPA_BRANCH => 'Некрасовой Елены Анатольевны',
            AnketaHelper::POKROV_BRANCH => 'Бойченко Людмилы Васильевны',
            AnketaHelper::STAVROPOL_BRANCH => 'Сотниковой Натальи Николаевны',
            AnketaHelper::DERBENT_BRANCH => 'Гусейнова Руслана Джангировича',
            AnketaHelper::SERGIEV_POSAD_BRANCH => 'Морозовой Валентины Сергеевны',
            DictFacultyHelper::CHERNOHOVSK_BRANCH =>  'Мищенко Виктора Васильевича',
        ];
    }

    public static function directorNameNominativeFull($collegeStatus = false)
    {
        return [
            AnketaHelper::HEAD_UNIVERSITY => self::collegeVuzSwitcher($collegeStatus, self::FIO_NOMINATIVE),
            AnketaHelper::ANAPA_BRANCH => 'Некрасова Елена Анатольевна',
            AnketaHelper::POKROV_BRANCH => 'Бойченко Людмила Васильевна',
            AnketaHelper::STAVROPOL_BRANCH => 'Сотникова Наталья Николаевна',
            AnketaHelper::DERBENT_BRANCH => 'Гусейнов Руслан Джангирович',
            AnketaHelper::SERGIEV_POSAD_BRANCH => 'Морозова Валентина Сергеевна',
            DictFacultyHelper::CHERNOHOVSK_BRANCH =>  'Мищенко Виктор Васильевич',
        ];
    }

    public static function procuration($collegeStatus = false) // Доверенность
    {
        return [
            AnketaHelper::HEAD_UNIVERSITY => self::collegeVuzSwitcher($collegeStatus, self::PROCURATION),
            AnketaHelper::ANAPA_BRANCH => '№ 14 от 18 февр. 2024 г.',
            AnketaHelper::POKROV_BRANCH => '№ 13 от 18 февр. 2022 г.',
            AnketaHelper::STAVROPOL_BRANCH => '№ 11 от 18 февр. 2024 г.',
            AnketaHelper::DERBENT_BRANCH => '№ 14 от 18 февр. 2022 г.',
            AnketaHelper::SERGIEV_POSAD_BRANCH => '№ 43 от 06 июл. 2020 г.',
            DictFacultyHelper::CHERNOHOVSK_BRANCH => '№28 от 20 июня. 2023 г.',
        ];
    }

    public static function columnAgreement($column, $value)
    {
        $query = (new AgreementReadRepository())->readData()
            ->select('agreement.' . $column)->groupBy('agreement.' . $column);
        return ArrayHelper::map($query->all(), $column, $value);
    }

    public static function payPerDate($educationLevel, $educationForm, $faculty)
    {
        $universityChoice = DictFacultyHelper::getKeyFacultySetting($faculty);
        if ($universityChoice == AnketaHelper::HEAD_UNIVERSITY) {
            if ($educationLevel == DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL) {
                return '03.10';
            } elseif ($educationLevel == DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO) {
                return self::cameOnAugust31() ? '25.11' : '28.08';
            } else {
                if ($educationForm == DictCompetitiveGroupHelper::EDU_FORM_ZAOCH) {
                    return '28.09';
                } else {
                    return '28.08';
                }
            }
        } else {
            if ($educationLevel == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR) {
                if ($educationForm == DictCompetitiveGroupHelper::EDU_FORM_ZAOCH) {
                    return '28.10';
                } else {
                    return '28.08';
                }
            } else {
                return self::cameOnAugust31() ? '25.11' : '28.08';
            }
        }
    }

    private static function cameOnAugust31()
    {
        return strtotime(\date('Y-m-d h:i:s')) >= strtotime('2024-08-30 18:00:00');
    }

    private static function cameOnJuly18()
    {
        return strtotime(\date('Y-m-d h:i:s')) >= strtotime('2022-09-01 00:00:00') && strtotime(\date('Y-m-d h:i:s')) <= strtotime('2022-10-31 00:00:00');
    }


    private static function cameOnJuly18vCollage()
    {
        return strtotime(\date('Y-m-d h:i:s')) >= strtotime('2023-08-03 00:00:00') && strtotime(\date('Y-m-d h:i:s')) <= strtotime('2023-08-28 00:00:00');
    }

    private static function collegeVuzSwitcher($collegeStatus, $type)
    {
        if ($collegeStatus) {
            switch ($type) {
                case self::FIO_NOMINATIVE :
                    return self::cameOnJuly18vCollage() ?  "Балабаева Екатерина Александровна" : "Владимирова Татьяна Николаевна";
                    break;
                case self::FIO_GENITIVE :
                    return  self::cameOnJuly18vCollage() ? "Балабаевой Екатерины Александровны" :  "Владимировой Татьяны Николаевны";
                    break;
                case self::POSITION_NOMINATIVE :
                    return self::cameOnJuly18vCollage() ? "Проректор по учебно-методической работе" : "Проректор по связям с общественностью";
                    break;
                case self::POSITION_GENITIVE :
                    return  self::cameOnJuly18vCollage() ? "проректора по учебно-методической работе": "проректора по связям с общественностью";
                    break;
                case self::FIO_SHORT :
                    return self::cameOnJuly18vCollage() ? "Е.А. Балабаева" : "Т.Н. Владимирова";
                    break;
                case self::PROCURATION :
                    return self::cameOnJuly18vCollage() ? "№26 от 5 июня 2023 года" : "№ 4 от 01 фев. 2024 г.";
            }
        } else {
            switch ($type) {
                case self::FIO_NOMINATIVE :
                    return self::cameOnJuly18() ? "Дронов Виктор Павлович" : 'Страхов Василий Вячеславович';
                    break;
                case self::FIO_GENITIVE :
                    return self::cameOnJuly18() ? "Дронова Виктора Павловича" :  "Страхова Василия Вячеславовича";
                    break;
                case self::POSITION_NOMINATIVE :
                    return self::cameOnJuly18() ? "Первый проректор" : "Проректор по развитию";
                    break;
                case self::POSITION_GENITIVE :
                    return self::cameOnJuly18() ? "первого проректора" : "проректора по развитию";
                    break;
                case self::FIO_SHORT :
                    return self::cameOnJuly18() ? "В.П. Дронов" : "В.В. Страхов";
                    break;
                case self::PROCURATION :
                    return self::cameOnJuly18() ? "№ 55 от 01 сент. 2022  г." : "№ 43 от 15 июн. 2022 г.";
            }

        }
    }
}