<?php

use \modules\entrant\helpers\AnketaHelper;
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

$userId = $anketa->user_id;
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
        foreach ($anketa->getPermittedEducationLevels() as $level):
            ?>
            <div class="col-md-3 col-sm-6 col-xs-12 mt-10">
                <div class="level_block">
                    <h4><?= DictCompetitiveGroupHelper::eduLevelName($level) ?></h4>
                    <hr>
                        <?php
                        if ($level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR && $onlyCse) {
                            $cseButton = Html::a("Мои результаты ЕГЭ", "/abiturient/default/cse",
                                ["class" => "btn btn-bd-primary"]);
                            $attentionText = "<p>Перейти к выбору образовательных программ можно только после ввода 
                            Ваших результатов ЕГЭ</p>";

                            if(CseSubjectHelper::minNumberSubject($userId)){
                                echo "<div>".$cseButton. " ". AnketaHelper::determinateRequiredNumberOfButtons($level)."</div>";
                            }else{
                                echo $attentionText . " ". "<div>".$cseButton."</div>";
                            }
                        } else {
                            echo "<div>".AnketaHelper::determinateRequiredNumberOfButtons($level)."</div>";
                        }
                        ?>
                </div>
            </div>
        <?php
        endforeach;
        ?>
    </div>
</div>

