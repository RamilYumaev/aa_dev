<?php
/**
 * @var $facultyArray
 * @var $currentFaculty
 * @var $cg
 * @var $transformYear
 * @var $anketa modules\entrant\models\Anketa
 */

use dictionary\models\Faculty;
use \dictionary\helpers\DictCompetitiveGroupHelper;
use \dictionary\models\DictCompetitiveGroup;
use dictionary\helpers\DictDisciplineHelper;
use modules\entrant\helpers\CseSubjectHelper;
use yii\helpers\Html;
use modules\entrant\helpers\UserCgHelper;
use yii\widgets\Pjax;
use yii\web\View;
use \dictionary\models\DictDiscipline;
use \modules\entrant\helpers\Settings;
use \modules\entrant\helpers\AnketaHelper;

$this->title = "Выбор образовательных программ бакалавриата";

$this->params['breadcrumbs'][] = ['label' => 'Определение условий подачи документов', 'url' => ['/abiturient/anketa/step1']];
$this->params['breadcrumbs'][] = ['label' => 'Выбор уровня образования', 'url' => ['/abiturient/anketa/step2']];
$this->params['breadcrumbs'][] = $this->title;

$result = "";
//$userId = \Yii::$app->user->identity->getId();
//
//$userArray = DictDiscipline::cseToDisciplineConverter(
//    CseSubjectHelper::userSubjects($userId));
//
//$finalUserArrayCse = DictDiscipline::finalUserSubjectArray($userArray);
//
//$filteredCg = \Yii::$app->user->identity->cseFilterCg($finalUserArrayCse);
//
//$filteredFaculty = \Yii::$app->user->identity->cseFilterFaculty($filteredCg);


$filteredCg = \Yii::$app->user->identity->filtrationCgByCse();
$filteredFaculty = \Yii::$app->user->identity->filtrationFacultyByCse();
$anketa = \Yii::$app->user->identity->anketa();
$contractOnly = $anketa->onlyContract(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);

$setting = \Yii::$app->user->identity->setting();

?>
<?php
foreach ($currentFaculty as $faculty) {

    if (!in_array($faculty, $filteredFaculty) && $anketa->onlyCse()) {
        continue;
    }
    $cgFacultyBase = DictCompetitiveGroup::find()
        ->eduLevel(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR)
        ->contractOnly()
        ->ForeignerCgSwitch()
        ->currentAutoYear()
        ->faculty($faculty)
        ->orderBy(['education_form_id' => SORT_ASC, 'speciality_id' => SORT_ASC]);

        if (!in_array($anketa->current_edu_level, [AnketaHelper::SCHOOL_TYPE_SPO, AnketaHelper::SCHOOL_TYPE_NPO])) {
            $cgFacultyBase = (clone $cgFacultyBase)->onlySpoProgramExcept();
        }

$cgFaculty = $cgFacultyBase->all();
    if ($cgFaculty) {

        $result .= "<h3 class=\"text-center\">" . \dictionary\helpers\DictFacultyHelper::facultyList()[$faculty] . "</h3>";
        $result .=
            "<table class=\"table tabled-bordered\">
<tr>
<th>Код, Направление подготовки, профиль</th>
<th>Форма и срок обучения</th>
<th>Уровень образования</th>
<th>Необходимые предметы ЕГЭ</th>";
        if (!$anketa->onlyCse()) {
            $result .= "<th colspan=\"2\">Вступительные испытания для категорий граждан, имеющих право поступать без ЕГЭ</th>";
        }
        $result .= "</tr>";

        foreach ($cgFaculty as $currentCg) {

            if (!$setting->allowCgCseContractMoscow($currentCg)) {
                continue;
            }

            if (!in_array($currentCg->id, $filteredCg) && $anketa->onlyCse()) {
                continue;
            }

            $budgetAnalog = DictCompetitiveGroup::findBudgetAnalog($currentCg);

            $trColor = UserCgHelper::trColor($currentCg);
            $result .= "<tr" . $trColor . ">";
            $result .= "<td>";
            $result .= $currentCg->specialty->getCodeWithName();
            $result .= $currentCg->specialization ? ", профиль(-и) <strong>" . $currentCg->specialization->name
                . "</strong>" : "";
            $result .= "</td>";
            $result .= "<td>";
            $result .= DictCompetitiveGroupHelper::getEduForms()[$currentCg->education_form_id] . ", ";
            $result .= $currentCg->education_duration != 5 ? $currentCg->education_duration . " года"
                : $currentCg->education_duration . " лет";
            $result .= "</td>";
            $result .= "<td>";
            $result .= DictCompetitiveGroupHelper::eduLevelName($currentCg->edu_level);
            $result .= "</td>";
            $result .= "<td>";
            $result .= "<ol>";
            foreach ($currentCg->examinations as $examination) {

                $result .= "<li>";
                $result .= $examination->discipline->name;
                $result .= "</li>";
            }
            $result .= "</ol>";
            $result .= "</td>";
            if (!$anketa->onlyCse()) {
                $result .= "<td>";
                $result .= "<ol>";
                foreach ($currentCg->examinations as $examination) {

                    $result .= "<li>";
                    $result .= Html::a($examination->discipline->name, $examination->discipline->links,
                        ['target' => '_blank']);
                    $result .= "</li>";
                }
                $result .= "</ol>";
                $result .= "</td>";
            }
            $result .= "<td width=\"56px\">";
            $result .= "<a class=\"btn btn-default\" data-toggle=\"collapse\" href=\"#info-"
                . $currentCg->id .
                "\" aria-expanded=\"false\" 
aria-controls=\"info-" . $currentCg->id . "\"><span class=\"glyphicon glyphicon-search\" aria-hidden=\"true\"></span></a>";
            $result .= ($budgetAnalog["status"] && !$contractOnly) ?  UserCgHelper::link(
                    $budgetAnalog["cgContractId"],
                    DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT) :
                UserCgHelper::link(
                    $budgetAnalog["cgContractId"],
                    DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT);
            $result .= "</td>";
            $result .= "</tr>";
            $result .= "<tr id=\"info-" . $currentCg->id . "\" class=\"collapse\">";
            if (!$contractOnly) {
                $result .= "<td>Количество бюджетных мест:<br><strong>" .
                    ($currentCg->only_pay_status ? 'приём на платной основе' : $budgetAnalog["kcp"]);
            }
            $result .= "</strong></td>";
            $result .= "<td>";
            $result .= $budgetAnalog["competition_count"] && !$contractOnly ? ("Конкурс 2019: " . $budgetAnalog["competition_count"]) : "";
            $result .= "</td>";
            $result .= "<td>";
            $result .= $budgetAnalog["passing_score"] && !$contractOnly ? ("Проходной балл 2019 : " . $budgetAnalog["passing_score"]) : "";
            $result .= "</td>";
            $result .= "<td>";
            $result .= $currentCg->link ? Html::a("Описание образовательной программы", $currentCg->link,
                ['target=> "_blank"']) : "";
            $result .= "</td>";
            $result .= "</tr>";
        }
    } else {
        continue;
    }
    $result .= "</table>";
}
?>
<?php Pjax::begin(['id' => 'get-bachelor', 'timeout' => false, 'enablePushState' => false]); ?>
<div class="row min-scr">
    <div class="button-left">
        <?= Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"]) . " Уровни",
            ["anketa/step2"], ["class" => "btn btn-lg btn-warning position-fixed"]); ?>
    </div>
    <div class="button-right">
        <?= Html::a("Карточка " . Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-right"]), ["/abiturient"], ["class" => "btn btn-lg btn-success position-fixed"]); ?>
    </div>
</div>
<div class="container">
    <h2 class="text-center"><?= $this->title ?></h2>
    <div class="row">

        <p class="text-danger fs-15">Прием документов по вступительным испытаниями и по результатам ЕГЭ на очную и очно-заочную формы обучения бюджетной основы завершен.
            <a target="_blank" href="http://mpgu.su/postuplenie/aktualno-prijomnaja-kampanija-2020/">Подробнее</a>.</p>
        <div class="col-md-6">
            <?= Html::img("/img/cabinet/btn-budget-plus.png", ["width" => "23px", "height" => "20px"]) ?>
            - кнопка выбора образовательной программы на бюджетной основе.<br/><br/>
            <?= Html::img("/img/cabinet/btn-budget-minus.png", ["width" => "23px", "height" => "20px"]) ?>
            - кнопка отмены выбора образовательной программы на бюджетной основе.
        </div>
        <div class="col-md-6">
            <?= Html::img("/img/cabinet/btn-dogovor-plus.png", ["width" => "23px", "height" => "20px"]) ?>
            - кнопка выбора образовательной программы на договорной основе.<br/><br/>
            <?= Html::img("/img/cabinet/btn-dogovor-minus.png", ["width" => "23px", "height" => "20px"]) ?>
            - кнопка отмены выбора образовательной программы на договорной основе.
        </div>
    </div>
    <div class="table-responsive">
        <?= $result ?>
    </div>
</div>


<?php
$this->registerJs("
        $('[data-toggle=\"collapse\"]').on('click', function () {
        $(this).children('span').toggleClass('glyphicon-search glyphicon-remove');
        });
", View::POS_READY);

?>


<?php Pjax::end(); ?>

<?php
$this->registerJs("
            $(document).on('pjax:send', function () {
            const buttonPlus = $('.glyphicon-plus');
            const buttonMinus = $('.glyphicon-minus');
            const buttonWrapper = $('.btn');
            buttonPlus.addClass(\"glyphicon-time\");
            buttonMinus.addClass(\"glyphicon-time\");
            buttonWrapper.attr('disabled', 'true');
            buttonPlus.removeClass(\"glyphicon-plus\");
            buttonMinus.removeClass(\"glyphicon-minus\");
        })
    ", View::POS_READY);


?>



