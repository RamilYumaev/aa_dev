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
$this->title = "Выбор уровня образования";
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
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-50">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    </div>
    <div class="row">
        <?php
        if (!in_array($anketa->current_edu_level, [AnketaHelper::SCHOOL_TYPE_SCHOOL_9]) &&
            ($anketa->category_id == CategoryStruct::GENERAL_COMPETITION
                || $anketa->category_id == CategoryStruct::COMPATRIOT_COMPETITION)
            && !AgreementHelper::isExits($anketa->user_id)): ?>
        <div class="col-md-6">
            <?= Html::a('Добавить данные договора о целевом обучении', ['agreement/index'],['class' => 'btn btn-primary']) ?>
        </div>
        <?php endif; if(($anketa->category_id == CategoryStruct::GENERAL_COMPETITION
            || $anketa->category_id == CategoryStruct::COMPATRIOT_COMPETITION)
            && in_array($anketa->current_edu_level, AnketaHelper::educationLevelSpecialRight())
            && !OtherDocumentHelper::isExitsExemption($anketa->user_id)): ?>
        <div class="col-md-6">
            <?= Html::a('Добавить данные документа, подтверждающий принадлежность к категориям особой квоты', ['other-document/exemption'],['class' => 'btn btn-warning']) ?>
        </div>
        <?php endif; ?>
    </div>
    <?php foreach (SettingEntrant::find()->groupData($anketa->getPermittedEducationLevels(), 'faculty_id') as $department) : ?>
        <div class="row">
        <div class="col-md-12 mt-50">
            <h2><?=  DictFacultyHelper::facultyListSetting()[$department] ?></h2>
        </div>
        </div>
        <div class="row">
            <?php foreach ($anketa->getPermittedEducationLevels() as $level):
                if(SettingEntrant::find()->faculty($department)->eduLevelOpen($level)): ?>
            <div class="col-md-3 col-sm-6 col-xs-12 mt-10">
                <div class="level_block">
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
    endforeach; ?>
</div>

