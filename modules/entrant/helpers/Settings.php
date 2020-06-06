<?php


namespace modules\entrant\helpers;


use yii\base\Model;

class Settings extends Model
{
    public $ZukSpoOchMoscowBudget = '2020-08-25 00:00:00'; // Окончание приема ЗУК в СПО бюджет Москва
    public $ZukSpoOchFilialBudget = '2020-08-25 00:00:00'; // Окончание приема ЗУК в СПО бюджет Москва
    public $ZukSpoOchMoscowContract = '2020-08-25 00:00:00'; // Окончание приема ЗУК в СПО бюджет филиалы
    public $ZukSpoOchFilialContract = '2020-08-25 00:00:00'; // Окончание приема ЗУК в СПО договор филиалы
    public $ZukBacOchBudgetCse = '2020-06-03 00:00:00'; // Абитуриент - окончание приема очных и очно-заочных заявлений (ЕГЭ) бакалавриата бюджетной основы
    public $ZukBacOchBudgetMoscowVi = '2020-08-25 00:00:00'; // Абитуриент - окончание приема очных и очно-заочных заявлений (ВИ) бакалавриата бюджетной основы
    public $ZukBacZaOchBudgetFilialCse = '2020-08-25 00:00:00'; // Абитуриент - окончание приема заочных заявлений (ЕГЭ) бакалавриата бюджетной основы, НЕ для филиалов
    public $ZukBacZaOchBudgetFilialVi = "2020-08-25 00:00:00"; // Абитуриент - окончание приема заочных заявлений (ВИ) бакалавриата бюджетной основы, НЕ для филиалов
    public $ZukBacOchContractCse = "2020-08-25 00:00:00"; // Абитуриент - окончание приема очных и очно-заочных заявлений (ЕГЭ) бакалавриата договорной основы
    public $ZukBacOchContractVi = "2020-08-25 00:00:00"; // Абитуриент - окончание приема очных и очно-заочных заявлений (ВИ) бакалавриата договорной основы
    public $ZukBacZaOchContractMoscowCse = "2020-08-25 00:00:00"; // Абитуриент - окончание приема заочных заявлений (ЕГЭ) бакалавриата договорной основы, НЕ для филиалов
    public $ZukBacZaOchContractFilialVi = "2020-08-25 00:00:00"; // Абитуриент - окончание приема заочных заявлений (ВИ) бакалавриата договорной основы, НЕ для филиалов
    public $ZukMagOchBudget = "2020-08-25 00:00:00"; //Абитуриент - окончание приема очных и очно-заочных заявлений магистратуры бюджет
    public $ZukMagZaOchBudget = "2020-08-25 00:00:00"; //Абитуриент - окончание приема заочных заявлений магистратуры бюджет
    public $ZukAspOchBudget = "2020-08-25 00:00:00"; // Абитуриент - окончание приема очных заявлений аспирантуры бюджет
    public $ZukAspOchContract = "2020-08-25 00:00:00"; // Абитуриент - окончание приема очных заявлений аспирантуры договор
    public $ZukAspZaOchContract = "2020-08-25 00:00:00"; // Абитуриент - окончание приема заочных заявлений аспирантуры договор

    public $ZosSpoOchMoscowBudget = '2020-08-25 00:00:00'; // Окончание приема ЗУК в СПО бюджет Москва
    public $ZosSpoOchFilialBudget = '2020-08-25 00:00:00'; // Окончание приема ЗУК в СПО бюджет Москва
    public $ZosSpoOchMoscowContract = '2020-08-25 00:00:00'; // Окончание приема ЗУК в СПО бюджет филиалы
    public $ZosSpoOchFilialContract = '2020-08-25 00:00:00'; // Окончание приема ЗУК в СПО договор филиалы
    public $ZosBacOchBudgetCse = '2020-08-25 00:00:00'; // Абитуриент - окончание приема очных и очно-заочных заявлений (ЕГЭ) бакалавриата бюджетной основы
    public $ZosBacOchBudgetVi = '2020-08-25 00:00:00'; // Абитуриент - окончание приема очных и очно-заочных заявлений (ВИ) бакалавриата бюджетной основы
    public $ZosBacZaOchBudgetMoscowCse = '2020-08-25 00:00:00'; // Абитуриент - окончание приема заочных заявлений (ЕГЭ) бакалавриата бюджетной основы, НЕ для филиалов
    public $ZosBacZaOchBudgetFilialVi = "2020-08-25 00:00:00"; // Абитуриент - окончание приема заочных заявлений (ВИ) бакалавриата бюджетной основы, НЕ для филиалов
    public $ZosBacOchContractCse = "2020-08-25 00:00:00"; // Абитуриент - окончание приема очных и очно-заочных заявлений (ЕГЭ) бакалавриата договорной основы
    public $ZosBacOchContractVi = "2020-08-25 00:00:00"; // Абитуриент - окончание приема очных и очно-заочных заявлений (ВИ) бакалавриата договорной основы
    public $ZosBacZaOchContractMoscowCse = "2020-08-25 00:00:00"; // Абитуриент - окончание приема заочных заявлений (ЕГЭ) бакалавриата договорной основы, НЕ для филиалов
    public $ZosBacZaOchContractFilialVi = "2020-08-25 00:00:00"; // Абитуриент - окончание приема заочных заявлений (ВИ) бакалавриата договорной основы, НЕ для филиалов
    public $ZosMagOchBudget = "2020-08-25 00:00:00"; //Абитуриент - окончание приема очных и очно-заочных заявлений магистратуры бюджет
    public $ZosMagZaOchBudget = "2020-08-25 00:00:00"; //Абитуриент - окончание приема заочных заявлений магистратуры бюджет
    public $ZosAspOchBudget = "2020-08-25 00:00:00"; // Абитуриент - окончание приема очных заявлений аспирантуры бюджет
    public $ZosAspOchContract = "2020-08-25 00:00:00"; // Абитуриент - окончание приема очных заявлений аспирантуры договор
    public $ZosAspZaOchContract = "2020-08-25 00:00:00"; // Абитуриент - окончание приема заочных заявлений аспирантуры договор

    public $ZidBacOchBudget = '2020-08-25 00:00:00'; // Абитуриент - окончание приема очных и очно-заочных ЗУК бакалавриата бюджетной основы
    public $ZidBacZaOchBudget = '2020-08-25 00:00:00'; // Абитуриент - окончание приема заочных ЗУК бакалавриата бюджетной основы
    public $ZidBacZaOchBudgetFilial = "2020-08-25 00:00:00"; // Абитуриент - окончание приема заочных заявлений бакалавриата бюджетной основы, НЕ для филиалов
    public $ZidMagOchBudget = "2020-08-25 00:00:00"; //Абитуриент - окончание приема очных и очно-заочных заявлений магистратуры бюджет
    public $ZidMagZaOchBudget = "2020-08-25 00:00:00"; //Абитуриент - окончание приема заочных заявлений магистратуры бюджет
    public $ZidAspOchBudget = "2020-08-25 00:00:00"; // Абитуриент - окончание приема очных заявлений аспирантуры бюджет
    public $ZidAspOchContract = "2020-08-25 00:00:00"; // Абитуриент - окончание приема очных заявлений аспирантуры договор
    public $ZidAspZaOchContract = "2020-08-25 00:00:00"; // Абитуриент - окончание приема заочных заявлений аспирантуры договор

    public $bansExport = false;


    public function allowBacCseOchBudget()
    {
        $arg1 = strtotime($this->ZukBacOchBudgetCse);
        $date = \date("Y-m-d h:i:s");
        $arg2 = strtotime(\date("Y-m-d h:i:s"));
        $boolData = $arg1 > $arg2;

        return $boolData;

    }

    public function allowBacViOchBudget()
    {
        return true;
    }

    public function allowBacCseZaOchBudget()
    {
        return true;
    }

    public function allowBacViZaOchBudget()
    {
        return true;
    }

    /**
     * @param $depart - головной вуз или филиал данные из анкеты
     * @return bool
     */

    public function allowBacCseOchContract($depart)
    {
        return true;
    }

    public function allowBacCseZaOchContract($depart)
    {
        return true;
    }

    /**
     * @param $depart - головной вуз или филиал данные из анкеты
     * @return bool
     */

    public function allowBacViOchContract($depart)
    {
        return true;
    }

    /**
     * @param $depart - головной вуз или филиал данные из анкеты
     * @return bool
     */

    public function allowBacViZaOchContract($depart)
    {
        return true;
    }

    public function allowMagOchBudget()
    {
        return true;
    }

    public function allowMagOchContract()
    {
        return true;
    }


}