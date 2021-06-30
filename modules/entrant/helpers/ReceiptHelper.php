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
            AnketaHelper::DERBENT_BRANCH => "УФК по Республике Дагестан отдел (Дербентский филиал МПГУ л/с 20036Э36740)",
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
            // AnketaHelper::HEAD_UNIVERSITY => "40501810845252000079 0321463000000017300",
            AnketaHelper::HEAD_UNIVERSITY => "03214643000000017300/40102810545370000003",
            AnketaHelper::ANAPA_BRANCH => "03214643000000011800/40102810945370000010",
            AnketaHelper::POKROV_BRANCH => "03214643000000012800/40102810945370000020",
            AnketaHelper::STAVROPOL_BRANCH => "03214643000000012100/40102810345370000013",
            AnketaHelper::SERGIEV_POSAD_BRANCH => "40501810545252000104",
            AnketaHelper::DERBENT_BRANCH => "03214643000000010300/40102810945370000069",
        ];
    }

    public static function bank()
    {
        return [
            AnketaHelper::HEAD_UNIVERSITY => "ГУ БАНКА РОССИИ ПО ЦФО//УФК ПО Г. МОСКВЕ г. Москва",
            AnketaHelper::ANAPA_BRANCH => "ЮЖНОЕ ГУ Банка России по Краснодарскому краю",
            AnketaHelper::POKROV_BRANCH => "ОТДЕЛЕНИЕ ВЛАДИМИР БАНКА РОССИИ",
            AnketaHelper::STAVROPOL_BRANCH => "ОТДЕЛЕНИЕ СТАВРОПОЛЬ БАНКА РОССИИ",
            AnketaHelper::SERGIEV_POSAD_BRANCH => "ГУ Банка России по ЦФО г.Москва 35",
            AnketaHelper::DERBENT_BRANCH => "ОТДЕЛЕНИЕ-НБ РЕСПУБЛИКА ДАГЕСТАН БАНКА РОССИИ",
        ];
    }

    public static function bik()
    {
        return [
            AnketaHelper::HEAD_UNIVERSITY => "004525988",
            AnketaHelper::ANAPA_BRANCH => "010349101",
            AnketaHelper::POKROV_BRANCH => "011708377",
            AnketaHelper::STAVROPOL_BRANCH => "010702101",
            AnketaHelper::SERGIEV_POSAD_BRANCH => "044525000",
            AnketaHelper::DERBENT_BRANCH => "018209001",
        ];
    }

    public static function oktmo(){
        return [
            AnketaHelper::HEAD_UNIVERSITY => "45383000",
            AnketaHelper::ANAPA_BRANCH => "03703000",
            AnketaHelper::POKROV_BRANCH => "17646120",
            AnketaHelper::STAVROPOL_BRANCH => "07701000",
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
        $v7 = "Казначейский счёт/Единый казначейский счет ".self::checkingAccount()[$key]."<br/>";
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