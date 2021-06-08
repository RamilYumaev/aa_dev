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
use modules\dictionary\models\SettingEntrant;
use modules\entrant\helpers\CseSubjectHelper;
use yii\helpers\Html;
use modules\entrant\helpers\UserCgHelper;
use yii\widgets\Pjax;
use yii\web\View;
use \dictionary\models\DictDiscipline;
use \modules\entrant\helpers\Settings;
use \modules\entrant\helpers\AnketaHelper;

$this->title = "Институты/факультеты (прием на целевое обучение)";

$this->params['breadcrumbs'][] = ['label' => 'Определение условий подачи документов', 'url' => ['/abiturient/anketa/step1']];
$this->params['breadcrumbs'][] = ['label' => 'Выбор уровня образования', 'url' => ['/abiturient/anketa/step2']];
$this->params['breadcrumbs'][] = $this->title;

$result = "";
$lastYear = \date("Y")-1;
$userId = \Yii::$app->user->identity->getId();
$anketa = \Yii::$app->user->identity->anketa();
$filteredCg = \Yii::$app->user->identity->filtrationCgByCse();
$filteredFaculty = \Yii::$app->user->identity->filtrationFacultyByCse();

?>
<?php
foreach ($currentFaculty as $faculty) {

    if (!in_array($faculty, $filteredFaculty) && $anketa->onlyCse()) {
        continue;
    }
    $cgFacultyBase = DictCompetitiveGroup::find()
        ->eduLevel(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR)
        ->onlyTarget()
        ->withoutForeignerCg()
        ->currentAutoYear()
        ->faculty($faculty)
        ->orderBy(['education_form_id' => SORT_ASC, 'speciality_id' => SORT_ASC]);

    if (!in_array($anketa->current_edu_level, [AnketaHelper::SCHOOL_TYPE_SPO, AnketaHelper::SCHOOL_TYPE_NPO])) {
        $cgFacultyBase = (clone $cgFacultyBase)->onlySpoProgramExcept();
    }
    $cgFacultyBase->successSpeciality($anketa->current_edu_level == AnketaHelper::SCHOOL_TYPE_SPO, $anketa->speciality_spo);
    $cgFaculty = $cgFacultyBase->all();

    if ($cgFaculty) {
        $result .= "<h3>" .Html::a(\dictionary\helpers\DictFacultyHelper::facultyList()[$faculty],['get-target-bachelor', 'department'=> $department, 'faculty'=> $faculty]) . "</h3>";
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


