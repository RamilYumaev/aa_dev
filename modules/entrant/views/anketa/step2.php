<?php

use \modules\entrant\helpers\AnketaHelper;
use \yii\helpers\Html;
use \dictionary\helpers\DictCompetitiveGroupHelper;
use \modules\entrant\helpers\CseSubjectHelper;

/**
 * @var $anketa modules\entrant\models\Anketa
 * @var $this yii\web\View
 */
$this->title = "Анкета. Шаг 2.";
?>
<div class="row">
    <div class="col-md-1">
        <?= Html::a("Назад к шагу 1", ["step1"], ["class" => "btn btn-success position-fixed mt-10"]) ?>
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
            <div class="col-md-3 simplePlace dashedBlue">
                <div class="dark_blue_sky">
                    <h4><?= DictCompetitiveGroupHelper::eduLevelName($level) ?></h4>
                </div>
                <div>
                    <?php if ($level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR &&
                        Yii::$app->user->identity->anketa()->onlyCse()) {
                        echo Html::a("Внести результаты ЕГЭ", "/abiturient/default/cse");
                        if (CseSubjectHelper::minNumberSubject(Yii::$app->user->identity->getId())) {
                            echo AnketaHelper::getButton($level);
                        }else{
                            echo "<p>Перейти к выбору образовательных программ можно только после ввода сданных предметов ЕГЭ</p>";
                        }

                    } else {
                        echo AnketaHelper::getButton($level);
                    }
                    ?>


                </div>
            </div>
        <?php
        endforeach;
        ?>
    </div>
</div>

