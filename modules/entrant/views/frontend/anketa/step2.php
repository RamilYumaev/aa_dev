<?php

use dictionary\helpers\DictFacultyHelper;
use modules\dictionary\models\SettingEntrant;
use modules\entrant\helpers\AgreementHelper;
use \modules\entrant\helpers\AnketaHelper;
use modules\entrant\helpers\CategoryStruct;
use modules\entrant\helpers\OtherDocumentHelper;
use \yii\helpers\Html;
use \dictionary\helpers\DictCompetitiveGroupHelper;
use \modules\entrant\helpers\CseSubjectHelper;

/**
 * @var $anketa modules\entrant\models\Anketa
 * @var $this yii\web\View
 */
$this->title = "Определение условий подачи документов. Шаг 2.";
$this->params['breadcrumbs'][] = ['label' => 'Определение условий подачи документов', 'url' => ['/abiturient/anketa/step1/']];
$this->params['breadcrumbs'][] = $this->title;

$onlyCse = $anketa->onlyCse();

?>

<div class="row min-scr">
    <div class="button-left">
        <?= Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"])." Условия",
            ["step1"], ["class" => "btn btn-warning btn-lg"]) ?>
    </div>
</div>

<style>
    summary::-webkit-details-marker{display:none;}
    summary::-moz-list-bullet{list-style-type:none;}
    summary::marker{display:none;}
    summary {
        margin-left: 25%;
        padding: .3em .6em .3em 1.5em;
        display:inline-block;
        font-size:1.7em;
        cursor: pointer;
        position: relative;
    }
    summary:before {
        left: .30em;
        top: .4em;
        color: transparent;
        background: url("data:image/svg+xml;base64,PHN2ZyBoZWlnaHQ9IjM0IiB2aWV3Qm94PSIwIDAgMjQgMjQiIHdpZHRoPSIzNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNOC41OSAxNi4zNGw0LjU4LTQuNTktNC41OC00LjU5TDEwIDUuNzVsNiA2LTYgNnoiLz48L3N2Zz4=") no-repeat 50% 50% / 1em 1em;
        width: 1em;
        height: 1em;
        content: "";
        position: absolute;
        transition: transform .5s;
    }
    details[open] > summary:before {
        transform: rotateZ(90deg);
    }
    summary ~ * {
        padding:0 1em 0 1em;
    }
    details[open] summary ~ *{
        animation: sweep .5s ease-in-out;
    }
    @keyframes sweep {
        0%    {opacity: 0;}
        100%  {opacity: 1;}
    }
    summary:focus {
        outline:0;
       /* box-shadow: inset 0 0 1px rgba(0,0,0,0.3), inset 0 0 2px rgba(0,0,0,0.3);*/
    }
    details{
        display:block;
        margin-bottom: .5rem;
    }
</style>





<div class="container">
    <div class="row">
        <div class="col-md-12 mt-50">
            <h2 align="center"><?= Html::encode($this->title) ?></h2>
        </div>
    </div>
    <div class="row">
        <?php
        if (!in_array($anketa->current_edu_level, [AnketaHelper::SCHOOL_TYPE_SCHOOL_9]) &&
            ($anketa->category_id == CategoryStruct::GENERAL_COMPETITION
                || $anketa->category_id == CategoryStruct::COMPATRIOT_COMPETITION)
            && !AgreementHelper::isExits($anketa->user_id)): ?>
        <div class="col-md-3 col-md-offset-2 mt-50" align="center">
            <?=Html::img("/img/cabinet/OLD/bak_form.png")?><br/>
            <?= Html::a('Добавить договор о целевом обучении', ['agreement/index']) ?>
        </div>
        <?php endif; if(($anketa->category_id == CategoryStruct::GENERAL_COMPETITION
            || $anketa->category_id == CategoryStruct::COMPATRIOT_COMPETITION)
            && in_array($anketa->current_edu_level, AnketaHelper::educationLevelSpecialRight())
            && !OtherDocumentHelper::isExitsExemption($anketa->user_id)): ?>
        <div class="col-md-3 mt-50" align="center">
            <?=Html::img("/img/cabinet/OLD/mag_form.png")?><br/>
            <?= Html::a('Добавить документ для особой квоты', ['other-document/exemption']) ?>
        </div>
        <?php endif; if(($anketa->category_id == CategoryStruct::GENERAL_COMPETITION
                || $anketa->category_id == CategoryStruct::COMPATRIOT_COMPETITION)
            && in_array($anketa->current_edu_level, AnketaHelper::educationLevelSpecialRight())
            && !OtherDocumentHelper::isExitsSpecialQuota($anketa->user_id)): ?>
            <div class="col-md-3 mt-50" align="center">
                <?=Html::img("/img/cabinet/OLD/mag_form.png")?><br/>
                <?= Html::a('Добавить документ для специальной квоты в соответствии с Указом Президента РФ №268 от 09.05.2022г.', ['other-document/special-quota']) ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="mt-50">
    <?php foreach (SettingEntrant::find()->groupData($anketa->getPermittedEducationLevels(), 'faculty_id') as $department) : ?>
        <details>
<summary><p align="center"><?=  DictFacultyHelper::facultyListSetting()[$department] ?></p></summary>

        <div class="row">
            <?php foreach ($anketa->getPermittedEducationLevels() as $level):
                if(SettingEntrant::find()->faculty($department)->eduLevelOpen($level)): ?>
            <div class="col-md-3 col-sm-6 col-xs-12 mt-10">
                <div class="level_block" style="min-height: 377px">
                    <h4><?= DictCompetitiveGroupHelper::eduLevelName($level) ?></h4>
                    <hr>
                        <?php
                        if ($level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR && $onlyCse) {
                            $cseButton = Html::a("Мои результаты ЕГЭ", "/abiturient/user-discipline/index",
                                ["class" => "btn btn-bd-primary"]);
                            $attentionText = "<p>Перейти к выбору образовательных программ можно только после ввода 
                            Ваших результатов ЕГЭ</p>";
                            if($anketa->getUserDisciplineCseCt()->count() >= CseSubjectHelper::MIN_NEEDED_SUBJECT_CSE) {
                                echo "<div>".$cseButton. " ". AnketaHelper::determinateRequiredNumberOfButtons($level, $department)."</div>";
                            }else{
                                echo $attentionText . " ". "<div>".$cseButton. ' '.AnketaHelper::determinateRequiredNumberOfButtons($level, $department, false)."</div>";
                            }
                        } else {
                            echo "<div>".AnketaHelper::determinateRequiredNumberOfButtons($level, $department)."</div>";
                        }
                        ?>
                </div>
            </div>

        <?php endif; endforeach; ?>
        </div>
    <?php
    if ($anketa->isTpgu() && $department == AnketaHelper::HEAD_UNIVERSITY) break;
    ?>
        </details>
            <?php
    endforeach; ?>
    </div>
</div>

