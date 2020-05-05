<?php
/**
 * @var $facultyArray
 * @var $currentFaculty
 * @var $cg
 * @var $transformYear
 */

use dictionary\models\Faculty;
use \dictionary\helpers\DictCompetitiveGroupHelper;
use \dictionary\models\DictCompetitiveGroup;
use dictionary\helpers\DictDisciplineHelper;
use yii\helpers\Html;
use modules\entrant\helpers\UserCgHelper;
use yii\widgets\Pjax;
use yii\web\View;

$this->title = "Выбор образовательных программ аспирантуры";

$this->params['breadcrumbs'][] = ['label' => 'Определение условий подачи документов', 'url' => ['/abiturient/anketa/step1']];
$this->params['breadcrumbs'][] = ['label' => 'Выбор уровня образования', 'url' => ['/abiturient/anketa/step2']];
$this->params['breadcrumbs'][] = $this->title;

$anketa = \Yii::$app->user->identity->anketa();
$contractOnly = $anketa->onlyContract(DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL);

$result = "";
?>
<?php
foreach ($currentFaculty as $faculty) {
    $cgFaculty = DictCompetitiveGroup::find()
        ->eduLevel(DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL)
        ->contractOnly()
        ->ForeignerCgSwitch()
        ->currentAutoYear()
        ->faculty($faculty)
        ->orderBy(['education_form_id' => SORT_ASC, 'speciality_id' => SORT_ASC])
        ->all();

    if ($cgFaculty) {

        $result .= "<h3 class=\"text-center\">" . \dictionary\helpers\DictFacultyHelper::facultyList()[$faculty] . "</h3>";
        $result .=
            "<table class=\"table tabled-bordered\">
<tr>
<th width=\"342\">Код, Направление подготовки, Основная профессиональная образовательная программа</th>
<th width=\"180\">Форма и срок обучения</th>
<th width=\"150\">Уровень образования</th>
<th colspan=\"2\">Вступительные испытания</th>
</tr>";
        foreach ($cgFaculty as $currentCg) {

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
                $result .= Html::a(DictDisciplineHelper::disciplineName($examination->discipline_id),
                    $examination->discipline->links,
                    ['target' => '_blank']);
                $result .= "</li>";
            }
            $result .= "</ol>";
            $result .= "</td>";
            $result .= "<td width=\"56px\">";
            $result .= "<a class=\"btn btn-default\" data-toggle=\"collapse\" href=\"#info-"
                . $currentCg->id .
                "\" aria-expanded=\"false\" 
aria-controls=\"info-" . $currentCg->id . "\"><span class=\"glyphicon glyphicon-search\" aria-hidden=\"true\"></span></a>";

            $result .= $budgetAnalog["status"] && !$contractOnly ? UserCgHelper::link(
                    $budgetAnalog["cgBudgetId"],
                    DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET)
                . UserCgHelper::link(
                    $budgetAnalog["cgContractId"],
                    DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT) :
                UserCgHelper::link(
                    $budgetAnalog["cgContractId"],
                    DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT);
            $result .= "</td>";
            $result .= "</tr>";
            $result .= "<tr id=\"info-" . $currentCg->id . "\" class=\"collapse\">";
            $result .= "<td>Количество бюджетных мест:<br><strong>" .
                ($currentCg->only_pay_status ? 'приём на платной основе' : $budgetAnalog["kcp"]);
            $result .= "</strong></td>";
            $result .= "<td>";
            if (!$contractOnly) {
                $result .= $budgetAnalog["competition_count"] ? ("Конкурс: " . $budgetAnalog["competition_count"]) : "";
            }
            $result .= "</td>";
            $result .= "<td>";
            if(!$contractOnly) {
                $result .= $budgetAnalog["passing_score"] ? ("Проходной балл: " . $budgetAnalog["passing_score"]) : "";
            }
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
<div class="row">
    <div class="col-md-1 mt-10">
        <?= Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"]), ["anketa/step2"], ["class" => "btn btn-warning position-fixed"]); ?>
    </div>
    <div class="col-md-1 col-md-offset-11">
        <?= Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-right"]), ["/abiturient"], ["class" => "btn btn-success position-fixed"]); ?>
    </div>
</div>
<h2 class="text-center"><?= $this->title ?></h2>
<div class="container">
    <?= $result ?>
</div>
<?php Pjax::end(); ?>

<?php
$this->registerJs("
            $(document).on('pjax:send', function () {
            const buttonPlus = $('.glyphicon');
            const buttonWrapper = $('.btn');
            buttonPlus.addClass(\"glyphicon-time\");
            buttonWrapper.attr('disabled', 'true');
            buttonPlus.removeClass(\"glyphicon-plus\");
            buttonPlus.removeClass(\"glyphicon-minus\");

        })
    ", View::POS_READY);

?>


