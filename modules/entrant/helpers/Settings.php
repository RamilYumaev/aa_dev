<?php


namespace modules\entrant\helpers;


use dictionary\models\DictCompetitiveGroup;
use yii\base\Model;

class Settings extends Model
{
    public $ZukSpoOchMoscowBudget = '2020-08-25 00:00:00'; // Окончание приема ЗУК в СПО бюджет Москва
    public $ZukSpoOchFilialBudget = '2020-08-25 00:00:00'; // Окончание приема ЗУК в СПО бюджет Москва

    public $ZukSpoOchMoscowContract = '2020-08-25 00:00:00'; // Окончание приема ЗУК в СПО бюджет филиалы
    public $ZukSpoOchFilialContract = '2020-08-25 00:00:00'; // Окончание приема ЗУК в СПО договор филиалы

    public $ZukBacOchBudgetCse = '2020-06-07 01:00:00'; // Абитуриент - окончание приема очных и очно-заочных заявлений (ЕГЭ) бакалавриата бюджетной основы
    public $ZukBacOchBudgetVi = '2020-08-25 00:00:00'; // Абитуриент - окончание приема очных и очно-заочных заявлений (ВИ) бакалавриата бюджетной основы

    public $ZukBacZaOchBudgetCse = '2020-06-05 00:00:00'; // Абитуриент - окончание приема заочных заявлений (ЕГЭ) бакалавриата бюджетной основы, НЕ для филиалов
    public $ZukBacZaOchBudgetVi = "2020-08-25 00:00:00"; // Абитуриент - окончание приема заочных заявлений (ВИ) бакалавриата бюджетной основы, НЕ для филиалов

    public $ZukBacOchContractCse = "2020-08-25 00:00:00"; // Абитуриент - окончание приема очных и очно-заочных заявлений (ЕГЭ) бакалавриата договорной основы
    public $ZukBacOchContractVi = "2020-08-25 00:00:00"; // Абитуриент - окончание приема очных и очно-заочных заявлений (ВИ) бакалавриата договорной основы

    public $ZukBacZaOchContractMoscowCse = "2020-08-25 00:00:00"; // Абитуриент - окончание приема заочных заявлений (ЕГЭ) бакалавриата договорной основы, НЕ для филиалов
    public $ZukBacZaOchContractFilialVi = "2020-08-25 00:00:00"; // Абитуриент - окончание приема заочных заявлений (ВИ) бакалавриата договорной основы, НЕ для филиалов

    public $ZukMagOchBudget = "2020-08-25 00:00:00"; //Абитуриент - окончание приема очных и очно-заочных заявлений магистратуры бюджет
    public $ZukMagZaOchBudget = "2020-08-25 00:00:00"; //Абитуриент - окончание приема заочных заявлений магистратуры бюджет

    public $ZukAspOchBudget = "2020-08-25 00:00:00"; // Абитуриент - окончание приема очных заявлений аспирантуры бюджет

    public $ZukAspOchContract = "2020-08-25 00:00:00"; // Абитуриент - окончание приема очных заявлений аспирантуры договор
    public $ZukAspZaOchContract = "2020-08-25 00:00:00"; // Абитуриент - окончание приема заочных заявлений аспирантуры договор

    public $ZukUmsGovline = "2020-06-06 00:00:00";


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

    public function allowCgForDeadLineContract(DictCompetitiveGroup $cg, $depart)
    {
        $anketa = \Yii::$app->user->identity->anketa();
        if ($anketa->university_choice == AnketaHelper::HEAD_UNIVERSITY) {
            if (($cg->isOchCg() || $cg->isOchZaOchCg()) && !$cg->isUmsCg()) {
                return $this->allowBacCseOchContact();
            }
        } else {
            if (($cg->isOchCg() || $cg->isOchZaOchCg()) && !$cg->isUmsCg()) {
                return $this->allowBacCseOchContact();
            }
        }

        return true;
    }

    public function allowCgForDeadLineBudget(DictCompetitiveGroup $cg)
    {
        if (($cg->isOchCg() || $cg->isOchZaOchCg()) && $cg->isBudget() && !$cg->isUmsCg()) {
            return strtotime($this->ZukBacOchBudgetCse) > $this->currentDate();
        }

        if ($cg->isZaOchCg() && $cg->isBudget() && !$cg->isUmsCg()) {
            return strtotime($this->ZukBacZaOchBudgetCse) > $this->currentDate();
        }

        if ($cg->isUmsCg() && $cg->isBudget()) {
            return strtotime($this->ZukUmsGovline) > $this->currentDate();
        }

        return true;
    }

    public function allowCgViForDeadLine(DictCompetitiveGroup $cg)
    {

    }


    public function allowViOchBackBudget()
    {
        return strtotime($this->ZukBacOchBudgetVi) > $this->currentDate();
    }

    public function allowBacCseOchBudget()
    {
        return strtotime($this->ZukBacOchBudgetCse) > $this->currentDate();
    }

    public function allowBacCseOchContact()
    {
        return strtotime($this->ZukBacOchContractCse) > $this->currentDate();
    }

    public function allowBacViOchBudget()
    {
        return strtotime($this->ZukBacOchBudgetVi) > $this->currentDate();
    }

    public function allowBacCseZaOchBudgetMoscow()
    {
        return strtotime($this->ZukBacZaOchContractMoscowCse) > $this->currentDate();
    }

    public function allowBacViZaOchBudgetMoscow()
    {
        return true;
    }

    /**
     * @param $depart - головной вуз или филиал данные из анкеты
     * @return bool
     */

    public function allowBacCseOchContractMoscow()
    {
        return true;
    }

    public function allowBacCseZaOchContract($depart)
    {
        return strtotime($this->ZukBacOchContractCse) > $this->currentDate();

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

    public function currentDate()
    {
        \date_default_timezone_set('Europe/Moscow');
        return strtotime(\date("Y-m-d G:i:s"));
    }


}