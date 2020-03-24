<?php

use \modules\entrant\helpers\AnketaHelper;
use \yii\helpers\Html;
use \dictionary\helpers\DictCompetitiveGroupHelper;

/**
 * @var $anketa modules\entrant\models\Anketa
 * @var $this yii\web\View
 */
$this->title = "Анкета. Шаг 2";
?>
<div class="container">
    <div class="row">
        <?php
        foreach ($anketa->getPermittedEducationLevels() as $level):
            ?>
            <div class="col-md-3 simplePlace dashedBlue">
                <div class="dark_blue_sky">
                    <h4><?= DictCompetitiveGroupHelper::eduLevelName($level) ?></h4>
                </div>
                <?php if ($level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR): ?>
                    <div>
                        <?= Html::a("перейти к выбору программ", ["applications/get-bachelor"],
                            ["class" => "btn btn-warning"]) ?>

                    </div>
                <?php endif; ?>
            </div>
        <?php
        endforeach;
        ?>
    </div>
    <?= Html::a("Назад", ["step1"], ["class" => "btn btn-success"]) ?>
</div>

