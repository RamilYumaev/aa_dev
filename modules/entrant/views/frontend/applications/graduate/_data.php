<?php
/**
 * @var $facultyArray
 * @var $currentFaculty
 * @var $department
 * @var $cg
 * @var $transformYear
 * @var $anketa modules\entrant\models\Anketa
 */

use dictionary\models\Faculty;
use \dictionary\helpers\DictCompetitiveGroupHelper;
use \dictionary\models\DictCompetitiveGroup;
use dictionary\helpers\DictDisciplineHelper;
use modules\dictionary\models\CathedraCg;
use modules\dictionary\models\SettingEntrant;
use modules\entrant\helpers\CategoryStruct;
use modules\entrant\helpers\CseSubjectHelper;
use yii\helpers\Html;
use modules\entrant\helpers\UserCgHelper;
use yii\widgets\Pjax;
use yii\web\View;
use \dictionary\models\DictDiscipline;
use \modules\entrant\helpers\Settings;
use \modules\entrant\helpers\AnketaHelper;

$this->title = "Выбор образовательных программ аспирантуры";

$this->params['breadcrumbs'][] = ['label' => 'Определение условий подачи документов', 'url' => ['/abiturient/anketa/step1']];
$this->params['breadcrumbs'][] = ['label' => 'Выбор уровня образования', 'url' => ['/abiturient/anketa/step2']];
if($department == AnketaHelper::HEAD_UNIVERSITY) {
    $this->params['breadcrumbs'][] = ['label' => 'Институты/факультеты', 'url' => ['get-graduate', 'department'=> $department ]];
}
$this->params['breadcrumbs'][] = $this->title;

$anketa = \Yii::$app->user->identity->anketa();
$contractOnly = $anketa->onlyContract(DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL);

$umsSwitcher = 0;
if ($anketa->category_id == CategoryStruct::FOREIGNER_CONTRACT_COMPETITION ||
    $anketa->category_id == CategoryStruct::GOV_LINE_COMPETITION
) {
    $umsSwitcher = 1;
}

$currentYear = Date("Y");
$lastYear = $currentYear - 1;

$result = "";
?>
<?php
foreach ($currentFaculty as $faculty) {

    $cgFaculty = CathedraCg::find()
        ->innerJoinWith('cathedra')
        ->innerJoinWith('competitiveGroup')
        ->andWhere([DictCompetitiveGroup::tableName() . '.`faculty_id`' => $faculty])
        ->andWhere([DictCompetitiveGroup::tableName() . '.`financing_type_id`' => DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT])
        ->andWhere([DictCompetitiveGroup::tableName() . '.`foreigner_status`' => $umsSwitcher])
        ->andWhere([DictCompetitiveGroup::tableName() . '.`edu_level`' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL])
        ->andWhere([DictCompetitiveGroup::tableName() . '.`year`' => "$lastYear-$currentYear"])
        ->orderBy([DictCompetitiveGroup::tableName() .'.`education_form_id`' => SORT_ASC,
            DictCompetitiveGroup::tableName() .'.`speciality_id`' => SORT_ASC])
        ->all();

    if ($cgFaculty) {

        $result .= "<h3 class=\"text-center\">" . \dictionary\helpers\DictFacultyHelper::facultyList()[$faculty] . "</h3>";
        $result .=
            "<table class=\"table tabled-bordered\">
<tr>
<th width=\"250\">Код, Направление подготовки, Основная профессиональная образовательная программа</th>
<th width=\"200\">Кафедра</th>
<th width=\"120\">Форма и срок обучения</th>
<th width=\"100\">Уровень образования</th>
<th colspan=\"2\">Вступительные испытания</th>
</tr>";
        foreach ($cgFaculty as $currentCg) {
            if(!SettingEntrant::find()->isOpenFormZUK($currentCg->competitiveGroup)) {
                continue;
            }
            $budgetAnalog = DictCompetitiveGroup::findBudgetAnalog($currentCg->competitiveGroup);
            $trColor = UserCgHelper::trColor($currentCg->competitiveGroup);
            $result .= "<tr" . $trColor . ">";
            $result .= "<td>";
            $result .= $currentCg->competitiveGroup->specialty->getCodeWithName();
            $result .= $currentCg->competitiveGroup->specialization ? ", профиль(-и) <strong>" . $currentCg->competitiveGroup->specialization->name
                . "</strong>" : "";
            $result .= "</td>";
            $result .= "<td>";
            $result .= $currentCg->cathedra->name;
            $result .= "</td>";
            $result .= "<td>";
            $result .= DictCompetitiveGroupHelper::getEduForms()[$currentCg->competitiveGroup->education_form_id] . ", ";
            $result .= $currentCg->competitiveGroup->education_duration != 5 ? $currentCg->competitiveGroup->education_duration . " года"
                : $currentCg->competitiveGroup->education_duration . " лет";
            $result .= "</td>";
            $result .= "<td>";
            $result .= DictCompetitiveGroupHelper::eduLevelName($currentCg->competitiveGroup->edu_level);
            $result .= "</td>";
            $result .= "<td>";
            $result .= "<ol>";
            foreach ($currentCg->competitiveGroup->examinations as $examination) {

                $result .= "<li>";
                $result .= Html::a($examination->discipline->name,
                    $examination->discipline->links,
                    ['target' => '_blank']);
                $result .= "</li>";
            }
            $result .= "</ol>";
            $result .= "</td>";
            $result .= "<td width=\"56px\">";
            $result .= "<a class=\"btn btn-default\" data-toggle=\"collapse\" href=\"#info-"
                . $currentCg->competitiveGroup->id .
                "\" aria-expanded=\"false\" 
aria-controls=\"info-" . $currentCg->competitiveGroup->id . "\"><span class=\"glyphicon glyphicon-search\" aria-hidden=\"true\"></span></a>";

            $result .= $budgetAnalog["status"] && !$contractOnly ?  UserCgHelper::link(
                    $budgetAnalog["cgBudgetId"],
                    DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET, $currentCg->cathedra_id)
                .UserCgHelper::link(
                    $budgetAnalog["cgContractId"],
                    DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT, $currentCg->cathedra_id) :
                UserCgHelper::link(
                    $budgetAnalog["cgContractId"],
                    DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT, $currentCg->cathedra_id);
            $result .= "</td>";
            $result .= "</tr>";
            $result .= "<tr id=\"info-" . $currentCg->competitiveGroup->id . "\" class=\"collapse\">";
            $result .= "<td>Количество бюджетных мест:<br><strong>" .
                ($currentCg->competitiveGroup->only_pay_status ? 'приём на платной основе' : $budgetAnalog["kcp"]);
            $result .= "</strong></td>";
            $result .= "<td>";
            if (!$contractOnly) {
                $result .= $budgetAnalog["competition_count"] ? ("Конкурс: " . $budgetAnalog["competition_count"]) : "";
            }
            $result .= "</td>";
            $result .= "<td>";
            if (!$contractOnly) {
                $result .= $budgetAnalog["passing_score"] ? ("Проходной балл: " . $budgetAnalog["passing_score"]) : "";
            }
            $result .= "</td>";
            $result .= "<td>";
            $result .= $currentCg->competitiveGroup->link ? Html::a("Описание образовательной программы", $currentCg->competitiveGroup->link,
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
        <?= $department == AnketaHelper::HEAD_UNIVERSITY ?
            Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"]) . " Список факультетов",
                ['get-graduate', 'department'=> $department], ["class" => "btn btn-lg btn-warning position-fixed"]) :
            Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"]) . " Уровни",
                ["anketa/step2"], ["class" => "btn btn-lg btn-warning position-fixed"]); ?>
    </div>
    <div class="button-right">
        <?= Html::a("Карточка " . Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-right"]), ["/abiturient"], ["class" => "btn btn-lg btn-success position-fixed"]); ?>
    </div>
</div>
<div class="container">
    <h2 class="text-center"><?= $this->title ?></h2>
    <div class="row">
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


