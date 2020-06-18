<?php

/**
 * @var $currentFaculty;

 */

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\helpers\UserCgHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

$this->title = "Образовательные программы для иностранных граждан поступающих по гослинии";

$this->params['breadcrumbs'][] = ['label' => 'Определение условий подачи документов', 'url' => ['/abiturient/anketa/step1']];
$this->params['breadcrumbs'][] = ['label' => 'Выбор уровня образования', 'url' => ['/abiturient/anketa/step2']];
$this->params['breadcrumbs'][] = $this->title;

$result = "";

foreach ($currentFaculty as $faculty) {

    $cgFaculty = DictCompetitiveGroup::find()
        ->eduLevel(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR)
        ->budgetOnly()
        ->foreignerStatus(1)
        ->currentAutoYear()
        ->faculty($faculty)
        ->orderBy(['education_form_id' => SORT_ASC, 'speciality_id' => SORT_ASC])
        ->all();

    if ($cgFaculty) {

        $result .= "<h3 class=\"text-center\">" . \dictionary\helpers\DictFacultyHelper::facultyList()[$faculty] . "</h3>";
        $result .=
            "<table class=\"table tabled-bordered\">
<tr>
<th>Код, Направление подготовки, профиль</th>
<th>Форма и срок обучения</th>
<th>Уровень образования</th>
<th</th>
</tr>";

        foreach ($cgFaculty as $currentCg) {

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
            $result .= UserCgHelper::link($currentCg->id, DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET);
            $result .= "</td>";
            $result .= "</tr>";
        }

    }else{
        continue;
    }
    $result .= "</table>";
}

?>
    <?php Pjax::begin(['id' => 'get-gov-line-bachelor', 'timeout' => false, 'enablePushState' => false]); ?>
    <div class="row min-scr">
        <div class="button-left">
            <?= Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"]) . " Уровни",
                ["anketa/step2"], ["class" => "btn btn-lg btn-warning position-fixed"]); ?>
        </div>
        <div class="button-right">
            <?= Html::a("Карточка " . Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-right"]), ["/abiturient"], ["class" => "btn btn-lg btn-success position-fixed"]); ?>
        </div>
    </div>
    <h2 class="text-center mt-50"><?= $this->title ?></h2>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <?= Html::img("/img/cabinet/btn-budget-plus.png", ["width"=>"23px", "height"=> "20px"]) ?>
                - кнопка выбора образовательной программы на бюджетной основе.<br/><br/>
                <?= Html::img("/img/cabinet/btn-budget-minus.png", ["width"=>"23px", "height"=> "20px"])?>
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
