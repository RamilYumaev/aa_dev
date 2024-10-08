<?php

/**
 * @var $department
 * @var $currentFaculty;

 */

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\dictionary\models\CathedraCg;
use modules\dictionary\models\SettingEntrant;
use modules\entrant\helpers\AnketaHelper;
use modules\entrant\helpers\UserCgHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

$this->title = "Программы аспирантуры для иностранных граждан поступающих по гослини. Институты/факультеты";

$this->params['breadcrumbs'][] = ['label' => 'Определение условий подачи документов', 'url' => ['/abiturient/anketa/step1']];
$this->params['breadcrumbs'][] = ['label' => 'Выбор уровня образования', 'url' => ['/abiturient/anketa/step2']];
$this->params['breadcrumbs'][] = $this->title;

$result = "";

$currentYear = Date("Y");
$lastYear = $currentYear - 1;

if($currentFaculty) {

foreach ($currentFaculty as $faculty) {

    $cgFaculty = CathedraCg::find()
        ->innerJoinWith('cathedra')
        ->innerJoinWith('competitiveGroup')
        ->andWhere([DictCompetitiveGroup::tableName() . '.`faculty_id`' => $faculty])
        ->andWhere([DictCompetitiveGroup::tableName() . '.`financing_type_id`' => DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET])
        ->andWhere([DictCompetitiveGroup::tableName() . '.`foreigner_status`' => 1])
        ->andWhere([DictCompetitiveGroup::tableName() . '.`edu_level`' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL])
        ->andWhere([DictCompetitiveGroup::tableName() . '.`year`' => "$lastYear-$currentYear"])
        ->orderBy([DictCompetitiveGroup::tableName() . '.`education_form_id`' => SORT_ASC,
            DictCompetitiveGroup::tableName() . '.`speciality_id`' => SORT_ASC])
        ->all();

    if ($cgFaculty) {
        $result .= "<h3>" .Html::a(\dictionary\helpers\DictFacultyHelper::facultyList()[$faculty],['get-gov-line-graduate', 'department'=> $department, 'faculty'=> $faculty]) . "</h3>";
    }
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
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
    <h2 class="text-center"><?= $this->title ?></h2>
    <div class="table-responsive" style="margin-top: 25px">
        <?= $result ?>
    </div>
    </div>
    </div>
</div>


