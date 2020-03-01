<?php
/**
 * @var $facultyArray
 * @var $currentFaculty
 * @var $cg
 */

use dictionary\models\Faculty;
use \dictionary\helpers\DictCompetitiveGroupHelper;
use \dictionary\models\DictCompetitiveGroup;

$this->title = "Выбор образовательных программ";

$result = "";
foreach ($currentFaculty as $faculty) {
    $result .= "<h3 class=\"text-center\">" . Faculty::getAllFacultyName()[$faculty] . "</h3>";
    $cgFaculty = DictCompetitiveGroup::find()
        ->eduLevel(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR)
        ->faculty($faculty)->all();
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
            $result .= "</tr>";
        }
    } else {
        continue;
    }
}
?>

<h2 class="text-center"><?= $this->title ?></h2>
<div class="container">
    <?= $result ?>

</div>
