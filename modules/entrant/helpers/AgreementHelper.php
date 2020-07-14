<?php

namespace modules\entrant\helpers;

use common\helpers\EduYearHelper;
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\models\Agreement;
use modules\entrant\models\Anketa;
use modules\entrant\readRepositories\AgreementReadRepository;
use modules\entrant\readRepositories\StatementReadRepository;
use yii\helpers\ArrayHelper;

class AgreementHelper
{
    const STATUS_NEW = 0;
    const STATUS_VIEW = 1;
    const STATUS_ACCEPTED = 2;
    const STATUS_NO_ACCEPTED = 3;

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
        return Agreement::find()->andWhere(['user_id' => $user_id, 'year' => EduYearHelper::eduYear()])->exists();
    }

    public static function data($universityChoice)
    {
        return [
            'accidence' => self::accidence()[$universityChoice],
            'positionsGenitive' => self::positionsGenitive()[$universityChoice],
            'positionNominative' => self::positionNominative()[$universityChoice],
            'directorNameShort' => self::directorNameShort()[$universityChoice],
            'directorNameGenitiveFull' => self::directorNameGenitiveFull()[$universityChoice],
            'directorNameNominativeFull' => self::directorNameNominativeFull()[$universityChoice],
            'procuration' => self::procuration()[$universityChoice],

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
                                                Место нахождения: 119991, г. Москва,
                                                 ул. Малая Пироговская, д. 1, стр.1<br/>
                                                тел./факс: 8-499-245-03-10<br/>
                                                e-mail: mail@mpgu.su<br/>
                                                ОГРН 1027700215344<br/>
                                                ИНН 7704077771<br/>
                                                КПП 770401001<br/><br/>
                                                Банковские реквизиты:
                                                <br/><br/>
                                                ГУ Банка России по ЦФО<br/>
                                                БИК 044525000<br/>
                                                р/с 40501810845252000079<br/>
                                                ОКТМО 45383000<br/>
                                                КБК 00000000000000000130 - за оказание платных услуг<br/>
                                                УФК по г. Москве (МПГУ л/с 20736У53790)",
            AnketaHelper::ANAPA_BRANCH => "Федеральное государственное бюджетное образовательное учреждение 
                                           высшего образования «Московский педагогический государственный университет» <br/> 
                                                Место нахождения: 119991, г. Москва, ул. Малая Пироговская, д. 1, стр.1<br/>
                                                Адрес (место нахождения) филиала: _353410, Краснодарский край, г. Анапа, 
                                                ул. Астраханская, д. 88<br/>
                                                тел./факс: 8 (86133) 5-62-87<br/>
                                                e-mail: f_anapa@mpgu.su<br/>
                                                ОГРН 1027700215344<br/>
                                                ИНН 7704077771<br/>
                                                КПП 230143001<br/><br/>
                                                Банковские реквизиты:<br/><br/>
                                                Наименование банка –ЮЖНОЕ ГУ Банка России по Краснодарскому краю<br/>
                                                БИК – 040349001<br/>
                                                р/с – 40501810000002000002<br/>
                                                ОКТМО – 03703000<br/>
                                                КБК 00000000000000000130 – за оказание платных услуг<br/>
                                                л/с – Отдел №2 УФК по Краснодаскому краю 20186В01260",
            AnketaHelper::POKROV_BRANCH => "Федеральное государственное бюджетное образовательное учреждение высшего 
                                                образования «Московский педагогический государственный университет»<br/>  
                                                Место нахождения: 119991, г. Москва, ул. Малая Пироговская, д. 1, стр.1<br/>
                                                Адрес (место нахождения) филиала: 601120, Владимирская область, 
                                                Петушинский район, г.Покров, Спортивный проезд, д. 2<br/>
                                                тел./факс: 8(49243) 6-14-35<br/>
                                                e-mail: f_pokrov@mpgu.su<br/>
                                                ОГРН 1027700215344<br/>
                                                ИНН 7704077771<br/>
                                                КПП 332143001<br/>
                                                Банковские реквизиты:<br/>
                                                Наименование банка – Отделение Владимир г. Владимир<br/>
                                                БИК – 041708001<br/>
                                                р/с – 40501810400082000001<br/>
                                                ОКТМО – 17646120<br/>
                                                КБК 00000000000000000130 – за оказание платных услуг<br/> 
                                                л/с - УФК по Владимирской области (Покровский филиал МПГУ л/с 20286В01340)",
            AnketaHelper::STAVROPOL_BRANCH => "Федеральное государственное бюджетное образовательное учреждение высшего 
                                                образования «Московский педагогический государственный университет»<br/> 
                                            Место нахождения: 119991, г. Москва, ул. Малая Пироговская, д. 1, стр.1<br/>
                                            Адрес (место нахождения) филиала: 355042, Ставропольский край, г. Ставрополь, 
                                            ул. Доваторцев, 66Г<br/>
                                            тел./факс: 8(8652)52-16-88<br/>
                                            e-mail: f_stavropol@mpgu.su<br/>
                                            ОГРН 1027700215344<br/>
                                            ИНН 7704077771<br/>
                                            КПП 263543001<br/><br/>
                                            Банковские реквизиты: <br/><br/>
                                            Наименование банка – отделение Ставрополь г. Ставрополь<br/>
                                            БИК – 040702001<br/>
                                            р/с – 40501810700022000002<br/>
                                            ОКТМО –07701000001<br/>
                                            КБК 00000000000000000130 – за оказание платных услуг<br/>
                                            л/с - УФК по Ставропольскому краю (2133 Ставропольский филиал МПГУ л/сч 20216Э35050)",
            AnketaHelper::DERBENT_BRANCH => "Федеральное государственное бюджетное образовательное учреждение высшего 
                                                образования «Московский педагогический государственный университет»<br/>  
                                            Место нахождения: 119991, г. Москва, ул. Малая Пироговская, д. 1, стр.1<br/>
                                            Адрес (место нахождения) филиала: 368600, Республика Дагестан, г. Дербент, ул. 
                                            Буйнакского, д. 18<br/>
                                            тел./факс: 8(87240) 4-05-50<br/>
                                            e-mail: f_derbent@mpgu.su<br/>
                                            ОГРН 1027700215344<br/>
                                            ИНН 7704077771<br/>
                                            КПП 054243001<br/><br/>
                                            Банковские реквизиты:<br/><br/>
                                            Наименование банка – Отделение-НБ Республики Дагестан г. Махачкала<br/>
                                            БИК – 048209001<br/>
                                            р/с – 40501810800002000002<br/>
                                            ОКТМО – 82710000<br/>
                                            КБК 00000000000000000130 – за оказание платных услуг<br/>
                                            л/с – УФК по Республике Дагестан отдел №2 (Дербентский филиал МПГУ л/с 20036Э36740)",
            AnketaHelper::SERGIEV_POSAD_BRANCH => "Федеральное государственное бюджетное образовательное учреждение 
                                            высшего образования «Московский педагогический государственный университет»<br/>  
                                            Место нахождения: 119991, г. Москва, ул. Малая Пироговская, д. 1, стр.1<br/>
                                            Адрес (место нахождения) филиала: 141315, Московская область, г. Сергиев 
                                            Посад, ул. Разина д.1-А<br/>
                                            тел./факс: 8(496) 547-24-64<br/>
                                            e-mail: f_sergiev-posad@mpgu.su<br/>
                                            ОГРН 1027700215344<br/>
                                            ИНН 7704077771<br/>
                                            КПП 504243001<br/><br/>
                                            Банковские реквизиты: <br/><br/>
                                            Наименование банка – ГУ Банка России по ЦФО г.Москва 35<br/>
                                            БИК – 044525000<br/>
                                            р/с – 40501810545252000104<br/>
                                            ОКТМО – 46728000<br/>
                                            КБК 00000000000000000130 – за оказание платных услуг
                                            ",
        ];
    }

    public static function positionsGenitive()
    {
        return [
            AnketaHelper::HEAD_UNIVERSITY => 'первого проректора',
            AnketaHelper::ANAPA_BRANCH => 'директора анапского филиала',
            AnketaHelper::POKROV_BRANCH => 'директора покровского филиала',
            AnketaHelper::STAVROPOL_BRANCH => 'директора ставропольского филиала',
            AnketaHelper::DERBENT_BRANCH => 'директора дербентского филиала',
            AnketaHelper::SERGIEV_POSAD_BRANCH => 'директора сергиево-посадского филиала',
        ];
    }

    public static function positionNominative()
    {
        return [
            AnketaHelper::HEAD_UNIVERSITY => 'Первый проректор',
            AnketaHelper::ANAPA_BRANCH => 'Директор анапского филиала',
            AnketaHelper::POKROV_BRANCH => 'Директор покровского филиала',
            AnketaHelper::STAVROPOL_BRANCH => 'Директор ставропольского филиала',
            AnketaHelper::DERBENT_BRANCH => 'Директор дербентского филиала',
            AnketaHelper::SERGIEV_POSAD_BRANCH => 'Директор сергиево-посадского филиала',
        ];
    }

    public static function directorNameShort()
    {
        return [
            AnketaHelper::HEAD_UNIVERSITY => 'В.П. Дронов',
            AnketaHelper::ANAPA_BRANCH => 'Е.А. Некрасова',
            AnketaHelper::POKROV_BRANCH => 'Л.В. Бойченко',
            AnketaHelper::STAVROPOL_BRANCH => 'Н.Н. Сотникова',
            AnketaHelper::DERBENT_BRANCH => 'Р.Д. Гусейнов',
            AnketaHelper::SERGIEV_POSAD_BRANCH => 'В.С. Морозова',
        ];
    }

    public static function directorNameGenitiveFull()
    {
        return [
            AnketaHelper::HEAD_UNIVERSITY => 'Дронова Виктора Павловича',
            AnketaHelper::ANAPA_BRANCH => 'Некрасовой Елены Анатольевны',
            AnketaHelper::POKROV_BRANCH => 'Бойченко Людмилы Васильевны',
            AnketaHelper::STAVROPOL_BRANCH => 'Сотниковой Натальи Николаевны',
            AnketaHelper::DERBENT_BRANCH => 'Гусейнова Руслана Джангировича',
            AnketaHelper::SERGIEV_POSAD_BRANCH => 'Морозовой Валентины Сергеевны',
        ];
    }

    public static function directorNameNominativeFull()
    {
        return [
            AnketaHelper::HEAD_UNIVERSITY => 'Дронов Виктор Павлович',
            AnketaHelper::ANAPA_BRANCH => 'Некрасова Елена Анатольевна',
            AnketaHelper::POKROV_BRANCH => 'Бойченко Людмила Васильевна',
            AnketaHelper::STAVROPOL_BRANCH => 'Сотникова Наталья Николаевна',
            AnketaHelper::DERBENT_BRANCH => 'Гусейнов Руслан Джангирович',
            AnketaHelper::SERGIEV_POSAD_BRANCH => 'Морозова Валентина Сергеевна',
        ];
    }

    public static function procuration() // Доверенность
    {
        return [
            AnketaHelper::HEAD_UNIVERSITY => '№ 04 от 31 янв. 2020 г.',
            AnketaHelper::ANAPA_BRANCH => '№48 от 06 июля 2020 г.',
            AnketaHelper::POKROV_BRANCH => '№ 11 от 13 мая 2019 г.',
            AnketaHelper::STAVROPOL_BRANCH => '№ 30 от 12 мая 2020 г.',
            AnketaHelper::DERBENT_BRANCH => '№ 14 от 13 мая 2019 г.',
            AnketaHelper::SERGIEV_POSAD_BRANCH => '№ 43 от 06 июля 2020 г.',
        ];
    }

    public static function columnAgreement($column, $value) {
        $query = (new AgreementReadRepository())->readData()
            ->select('agreement.' . $column)->groupBy('agreement.' . $column);
        return ArrayHelper::map($query->all(), $column, $value);
    }

    public static function payPerDate($educationLevel, $educationForm, $universityChoice)
    {
        if ($universityChoice == AnketaHelper::HEAD_UNIVERSITY) {
            if ($educationLevel == DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL) {
                return '25 сентября';
            } elseif ($educationLevel == DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO) {
                return self::cameOnAugust31() ? '25 ноября' : '31 августа';
            } else {
                if ($educationForm == DictCompetitiveGroupHelper::EDU_FORM_ZAOCH) {
                    return '28 сентября';
                } else {
                    return '31 августа';
                }
            }
        } else {
            if ($educationLevel == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR) {
                if ($educationForm == DictCompetitiveGroupHelper::EDU_FORM_ZAOCH) {
                    return '30 октября';
                } else {
                    return '31 августа';
                }
            }else{
                return self::cameOnAugust31() ? '25 ноября' : '31 августа';
            }
        }
    }

    private static function cameOnAugust31()
    {
        return strtotime(\date('Y-m-d h:i:s')) >= strtotime('2020-08-31 18:00');
    }
}