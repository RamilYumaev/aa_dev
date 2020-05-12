<?php

use dictionary\models\DictDiscipline;
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
$userId = Yii::$app->user->identity->getId();
$anketa = Yii::$app->user->identity->anketa();
$onlyCse = $anketa->onlyCse();

?>
<div class="row">
    <div class="col-md-2">
        <?= Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"]),
            ["step1"], ["class" => "btn btn-success btn-lg mt-10 ml-30"]) ?>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-30">
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

