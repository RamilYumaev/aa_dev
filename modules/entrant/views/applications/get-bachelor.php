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

$this->title = "Выбор образовательных программ";

$result = "";
foreach ($currentFaculty as $faculty) {
    $result .= "<h3 class=\"text-center\">" . \dictionary\helpers\DictFacultyHelper::facultyList()[$faculty] . "</h3>";
    $cgFaculty = DictCompetitiveGroup::find()
        ->eduLevel(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR)
        ->budgetAndContractOnly()
        ->currentYear($transformYear)
        ->faculty($faculty)
        ->orderBy(['education_form_id' => SORT_ASC, 'speciality_id' => SORT_ASC])
        ->all();
    if ($cgFaculty) {
        $result .=
            "<table class=\"table tabled-bordered\">
<tr>
<th width=\"342\">Код, Направление подготовки, профиль</th>
<th width=\"180\">Форма и срок обучения</th>
<th width=\"150\">Уровень образования</th>
<th width=\"158\">Необходимые предметы ЕГЭ</th>
<th colspan=\"2\">Вступительные испытания для категорий граждан, имеющих право поступать без ЕГЭ</th>
</tr>";
        foreach ($cgFaculty as $currentCg) {
            $result .= "<tr>";
            $result .= "<td>";
            $result .= $currentCg->specialty->getCodeWithName();
            $result .= $currentCg->specialization->name ? ", профиль(-и) <strong>" . $currentCg->specialization->name . "</strong>" : "";
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
                $result .= DictDisciplineHelper::disciplineName($examination->discipline_id);
                $result .= "</li>";
            }
            $result .= "</ol>";
            $result .= "</td>";
            $result .= "<td>";
            $result .= "<ol>";
            foreach ($currentCg->examinations as $examination) {

                $result .= "<li>";
                $result .= DictDisciplineHelper::disciplineName($examination->discipline_id);
                $result .= "</li>";
            }
            $result .= "</ol>";
            $result .= "</td>";
            $result .= "<td width=\"56px\">";
            $result .= "<a class=\"btn btn-default\" data-toggle=\"collapse\" href=\"#info-"
                . $currentCg->id .
                "\" aria-expanded=\"false\" 
aria-controls=\"info-" . $currentCg->id . "\"><span class=\"glyphicon glyphicon-search\" aria-hidden=\"true\"></span></a>";
            $result .= Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-plus']),
                ['/reg-on-cg', 'id' => $currentCg->id],
                ['class' => 'btn btn-success']);
            $result .= Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-plus']),
                ['/reg-on-cg', 'id' => $currentCg->id],
                ['class' => 'btn btn-warning']);
            $result .= "</td>";
            $result .= "</tr>";
            $result .= "<tr id=\"info-" . $currentCg->id . "\" class=\"collapse\">";
            $result .= "<td>Количество бюджетных мест:<br><strong>" .
                ($currentCg->only_pay_status ? 'приём на платной основе' : $currentCg->kcp);
            $result .= "</strong></td>";
            $result .= "<td>";
            $result .= $currentCg->competition_count ? ("Конкурс: " . $currentCg->competition_count) : "";
            $result .= "</td>";
            $result .= "<td>";
            $result .= $currentCg->passing_score ? ("Проходной балл: " . $currentCg->passing_score) : "";
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

<h2 class="text-center"><?= $this->title ?></h2>
<div class="container">
    <?= $result ?>

</div>
