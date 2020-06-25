<?php

namespace modules\entrant\helpers;

use common\helpers\EduYearHelper;
use modules\entrant\models\Agreement;
use modules\entrant\models\Anketa;
use modules\entrant\readRepositories\AgreementReadRepository;
use modules\entrant\readRepositories\StatementReadRepository;
use yii\helpers\ArrayHelper;

class AgreementHelper
{
    const STATUS_NEW = 0;
    const STATUS_VIEW =1;
    const STATUS_ACCEPTED = 2;
    const STATUS_NO_ACCEPTED = 3;

    public static function statusList() {
        return[
            self::STATUS_NEW =>"Новое",
            self::STATUS_ACCEPTED =>"Принято",
            self::STATUS_NO_ACCEPTED =>"Не принято",
            self::STATUS_VIEW => "Взято в работу"];
    }

    public static function statusName($key) {
        return ArrayHelper::getValue(self::statusList(),$key);
    }


    public static function colorList() {
        return [
            self::STATUS_NEW=> "warning",
            self::STATUS_ACCEPTED =>"success",
            self::STATUS_NO_ACCEPTED =>"danger",
            self::STATUS_VIEW => "info"];
    }

    public static function colorName($key) {
        return ArrayHelper::getValue(self::colorList(),$key);
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
                                                Место нахождения: 119991, г.
                                                Москва, ул. Малая Пироговская,
                                                д. 1, стр.1<br/>
                                                ул. Малая Пироговская, д. 1, стр.1<br/>
                                                тел./факс 8-499-246-81-63<br/>
                                                e-mail: orgeconom_otd@mpgu.su –<br/>
                                                Организационно-экономический отдел<br/>
                                                ИНН 7704077771<br/>
                                                КПП 770401001<br/>
                                                УФК по г. Москве (МПГУ л/с 20736У53790)",
            AnketaHelper::ANAPA_BRANCH => "Анапский филиал федерального 
                                            государственного бюджетного 
                                            образовательного учреждения 
                                            высшего образования «Московский 
                                            педагогический государственный университет»<br/>
                                            ИНН/КПП – 7704077771/230143001<br/>
                                            ОКТМО – 03703000001<br/>
                                            ОГРН – 1027700215344<br/>
                                            КБК – 00000000000000000130<br/>
                                            Наименование банка –ЮЖНОЕ ГУ Банка России по Краснодарскому краю<br/>
                                            р/с – 40501810000002000002<br/>
                                            БИК – 040349001<br/>
                                            л/с – Отдел №2 УФК по Краснодаскому краю 20186В01260",
            AnketaHelper::POKROV_BRANCH => "Покровский филиал федерального 
                                            государственного бюджетного 
                                            образовательного учреждения 
                                            высшего образования «Московский 
                                            педагогический государственный университет»<br/>
                                            ИНН/КПП – 7704077771/332143001<br/>
                                            ОКТМО – 17646120<br/>
                                            ОГРН – 1027700215344<br/>
                                            КБК – 00000000000000000130<br/>
                                            Наименование банка – Отделение Владимир г. Владимир<br/>
                                            р/с – 40501810400082000001<br/>
                                            БИК – 041708001<br/>
                                            л/с - УФК по Владимирской области (Покровский филиал МПГУ л/с 20286В01340)",
            AnketaHelper::STAVROPOL_BRANCH => "
                                            Ставропольский филиал федерального 
                                            государственного бюджетного 
                                            образовательного учреждения 
                                            высшего образования «Московский 
                                            педагогический государственный университет»<br/>
                                            ИНН/КПП – 7704077771/263543001<br/>
                                            ОКТМО – 07701000001<br/>
                                            ОГРН – 1027700215344<br/>
                                            КБК – 00000000000000000130<br/>
                                            Наименование банка – отделение Ставрополь г. Ставрополь<br/>
                                            р/с – 40501810700022000002<br/>
                                            БИК – 040702001<br/>
                                            л/с - УФК по Ставропольскому краю (2133 Ставропольский филиал МПГУ л/сч 20216Э35050)",
            AnketaHelper::DERBENT_BRANCH => "
                                            Дербентский филиал федерального 
                                            государственного бюджетного 
                                            образовательного учреждения 
                                            высшего образования «Московский 
                                            педагогический государственный университет»<br/>
                                            ИНН/КПП – 7704077771/054243001<br/>
                                            ОКТМО – 82710000<br/>
                                            ОГРН – 1027700215344<br/>
                                            КБК – 00000000000000000130<br/>
                                            Наименование банка – Отделение-НБ Республики Дагестан г. Махачкала<br/>
                                            р/с – 40501810800002000002<br/>
                                            БИК – 048209001<br/>
                                            л/с – УФК по Республике Дагестан отдел №2 (Дербентский филиал МПГУ л/с 20036Э36740)",
            AnketaHelper::SERGIEV_POSAD_BRANCH => "Сергиево-Посадский филиал федерального 
                                            государственного бюджетного 
                                            образовательного учреждения 
                                            высшего образования «Московский 
                                            педагогический государственный университет»<br/>
                                            ИНН/КПП – 7704077771/504243001<br/>
                                            ОКТМО – 46728000<br/>
                                            ОГРН – 1027700215344<br/>
                                            КБК – 00000000000000000130<br/>
                                            Наименование банка – ГУ Банка России по ЦФО г.Москва 35<br/>
                                            р/с – 40501810545252000104<br/>
                                            БИК – 044525000<br/>
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
            AnketaHelper::ANAPA_BRANCH => '№ 10 от 30 апр. 2019 г.',
            AnketaHelper::POKROV_BRANCH => '№ 11 от 13 мая 2019 г.',
            AnketaHelper::STAVROPOL_BRANCH => '№ 17 от 13 мая 2019 г.',
            AnketaHelper::DERBENT_BRANCH => '№ 14 от 13 мая 2019 г.',
            AnketaHelper::SERGIEV_POSAD_BRANCH => '№ 29 от 12.05.2020 г.',
        ];
    }

    public static function columnAgreement($column, $value) {
        $query = (new AgreementReadRepository())->readData()
            ->select('agreement.'.$column)->groupBy('agreement.'.$column);
        return ArrayHelper::map($query->all(), $column, $value);
    }
}