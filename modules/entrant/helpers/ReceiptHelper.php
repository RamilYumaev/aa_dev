<?php


namespace modules\entrant\helpers;

class ReceiptHelper
{
    const PERIOD_YEAR = 3;
    const PERIOD_M_6 = 2;
    const PERIOD_M_3 = 1;

    public static function listPeriod ($cost) {
        return [
            self::PERIOD_M_3  =>  "по месяцам (".self::cost($cost,self::listSep()[self::PERIOD_M_3]).")",
            self::PERIOD_M_6  => "за семестр (".self::cost($cost, self::listSep()[self::PERIOD_M_6]).")",
            self::PERIOD_YEAR =>"за 1 год (".self::cost($cost,self::listSep()[self::PERIOD_YEAR]).")"];
    }

    public static function listSep () {
        return [
            self::PERIOD_M_3  => 12,
            self::PERIOD_M_6  => 2,
            self::PERIOD_YEAR =>1,
            ];
    }

    public static function cost($cost, $sep) {
        return \Yii::$app->formatter->asCurrency(round($cost/$sep,2));
    }

    public static function costDefault($cost, $sep) {
        return \Yii::$app->formatter->asDecimal(round($cost/$sep,2),2);
    }

    public static function personalAccount()
    {
        return [
            AnketaHelper::HEAD_UNIVERSITY => "УФК по г. Москве (МПГУ л/с 20736У53790)",
            AnketaHelper::ANAPA_BRANCH => "УФК по  Краснодарскому краю (Анапский филиал МПГУ л/с 20186В01260)",
            AnketaHelper::POKROV_BRANCH => "УФК по Владимирской области (Покровский филиал МПГУ л/с 20286В01340)",
            AnketaHelper::STAVROPOL_BRANCH => "УФК по Ставропольскому краю (2133 Ставропольский филиал МПГУ л/с 20216Э35050)",
            AnketaHelper::SERGIEV_POSAD_BRANCH => "УФК по Московской области (СПФ МПГУ л/с 20486Э39110)",
            AnketaHelper::DERBENT_BRANCH => "УФК по Республике Дагестан отдел №2 (Дербентский филиал МПГУ л/с 20036Э36740)",
        ];
    }

    public static function Inn()
    {
        return [
            AnketaHelper::HEAD_UNIVERSITY => "7704077771",
            AnketaHelper::ANAPA_BRANCH => "7704077771",
            AnketaHelper::POKROV_BRANCH => "7704077771",
            AnketaHelper::STAVROPOL_BRANCH => "7704077771",
            AnketaHelper::SERGIEV_POSAD_BRANCH => "770407777",
            AnketaHelper::DERBENT_BRANCH => "7704077771",
        ];
    }

    public static function kpp()
    {
        return [
            AnketaHelper::HEAD_UNIVERSITY => "770401001",
            AnketaHelper::ANAPA_BRANCH => "230143001",
            AnketaHelper::POKROV_BRANCH => "332143001",
            AnketaHelper::STAVROPOL_BRANCH => "263543001",
            AnketaHelper::SERGIEV_POSAD_BRANCH => "504243001",
            AnketaHelper::DERBENT_BRANCH => "054243001",
        ];
    }

    public static function checkingAccount()
    {
        return [
            AnketaHelper::HEAD_UNIVERSITY => "40501810845252000079",
            AnketaHelper::ANAPA_BRANCH => "40501810000002000002",
            AnketaHelper::POKROV_BRANCH => "40501810400082000001",
            AnketaHelper::STAVROPOL_BRANCH => "40501810700022000002",
            AnketaHelper::SERGIEV_POSAD_BRANCH => "40501810545252000104",
            AnketaHelper::DERBENT_BRANCH => "40501810800002000002",
        ];
    }

    public static function bank()
    {
        return [
            AnketaHelper::HEAD_UNIVERSITY => "ГУ Банка России по ЦФО",
            AnketaHelper::ANAPA_BRANCH => "ЮЖНОЕ ГУ Банка России по Краснодарскому краю",
            AnketaHelper::POKROV_BRANCH => "Отделение Владимир  г. Владимир",
            AnketaHelper::STAVROPOL_BRANCH => "Отделение Ставрополь г. Ставрополь",
            AnketaHelper::SERGIEV_POSAD_BRANCH => "ГУ Банка России по ЦФО г.Москва 35",
            AnketaHelper::DERBENT_BRANCH => "ОТДЕЛЕНИЕ-НБ РЕСПУБЛИКА ДАГЕСТАН Г. МАХАЧКАЛА",
        ];
    }

    public static function bik()
    {
        return [
            AnketaHelper::HEAD_UNIVERSITY => "044525000",
            AnketaHelper::ANAPA_BRANCH => "040349001",
            AnketaHelper::POKROV_BRANCH => "041708001",
            AnketaHelper::STAVROPOL_BRANCH => "040702001",
            AnketaHelper::SERGIEV_POSAD_BRANCH => "044525000",
            AnketaHelper::DERBENT_BRANCH => "048209001",
        ];
    }

    public static function oktmo(){
        return [
            AnketaHelper::HEAD_UNIVERSITY => "45383000",
            AnketaHelper::ANAPA_BRANCH => "03703000",
            AnketaHelper::POKROV_BRANCH => "17646120",
            AnketaHelper::STAVROPOL_BRANCH => "07701000001",
            AnketaHelper::SERGIEV_POSAD_BRANCH => "46728000",
            AnketaHelper::DERBENT_BRANCH => "82710000",
        ];
    }

    public static function header($key){
        $v1 = "<p><strong>БАНКОВСКИЕ РЕКВИЗИТЫ:</strong></p>";
        $v2 = "<p>ОГРН 1027700215344<br/>";
        $v3 = "ИНН ".self::inn()[$key]."<br/>";
        $v4 = "КПП ".self::kpp()[$key]."<br/>";
        $v5 = "".self::personalAccount()[$key]."<br/>";
        $v6 = "БИК ".self::bik()[$key]."<br/>";
        $v7 = "р/с ".self::checkingAccount()[$key]."<br/>";
        $v8 = "ОКТМО ".self::oktmo()[$key]."<br/>";
        $v9 = "КБК 00000000000000000130 - за оказание платных услуг</p>";
        return $v1.$v2.$v3.$v4.$v5.$v6.$v7.$v8.$v9;
    }


//AnketaHelper::HEAD_UNIVERSITY => "",
//AnketaHelper::ANAPA_BRANCH => "",
//AnketaHelper::POKROV_BRANCH => "",
//AnketaHelper::STAVROPOL_BRANCH => "",
//AnketaHelper::SERGIEV_POSAD_BRANCH => "",
//AnketaHelper::DERBENT_BRANCH => "",

}