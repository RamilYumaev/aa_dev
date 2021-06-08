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

$this->title = "Аспирантура. Факультеты";

$this->params['breadcrumbs'][] = ['label' => 'Определение условий подачи документов', 'url' => ['/abiturient/anketa/step1']];
$this->params['breadcrumbs'][] = ['label' => 'Выбор уровня образования', 'url' => ['/abiturient/anketa/step2']];
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
        $result .= "<h3>" .Html::a(\dictionary\helpers\DictFacultyHelper::facultyList()[$faculty],['get-graduate', 'department'=> $department, 'faculty'=> $faculty]) . "</h3>";
    }
}
?>
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
    <div class="table-responsive">
        <?= $result ?>
    </div>
</div>


