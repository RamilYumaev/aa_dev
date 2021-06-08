<?php

/**
 * @var $currentFaculty;
 * @var $department
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

$this->title = "Программы аспирантуры для иностранных граждан поступающих по гослини";

$this->params['breadcrumbs'][] = ['label' => 'Определение условий подачи документов', 'url' => ['/abiturient/anketa/step1']];
$this->params['breadcrumbs'][] = ['label' => 'Выбор уровня образования', 'url' => ['/abiturient/anketa/step2']];
if($department == AnketaHelper::HEAD_UNIVERSITY) {
    $this->params['breadcrumbs'][] = ['label' => 'Факультеты', 'url' => ['get-gov-line-graduate', 'department'=> $department ]];
}
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

            $result .= "<h3 class=\"text-center\">" . \dictionary\helpers\DictFacultyHelper::facultyList()[$faculty] . "</h3>";
            $result .=
                "<table class=\"table tabled-bordered\">
<tr>
<th>Код, Направление подготовки, профиль</th>
<th>Кафедра</th>
<th>Форма и срок обучения</th>
<th>Уровень образования</th>
<th</th>
</tr>";
            foreach ($cgFaculty as $currentCg) {
                if(!SettingEntrant::find()->isOpenFormZUK($currentCg)) {
                    continue;
                }

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
                $result .= UserCgHelper::link($currentCg->competitiveGroup->id, DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET);
                $result .= "</td>";
                $result .= "</tr>";
            }

        }else {
            continue;
        }
    }
}
$result .= "</table>";

?>
<?php Pjax::begin(['id' => 'get-bachelor', 'timeout' => false, 'enablePushState' => false]); ?>
    <div class="row min-scr">
        <div class="button-left">
            <?= $department == AnketaHelper::HEAD_UNIVERSITY ?
                Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"]) . " Список факультетов",
                    ['get-gov-line-graduate', 'department'=> $department], ["class" => "btn btn-lg btn-warning position-fixed"]) : Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"]) . " Уровни",
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
        </div>
        <div class="table-responsive">
            <?= $result ?>
        </div>
    </div>

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


