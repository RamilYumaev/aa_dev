<?php

use \yii\helpers\Html;

/**
 * @var $model \modules\entrant\models\UserIndividualAchievements
 */

?>
<div class="p-30 green-border">
<h4>Индивидуальные достижения</h4>
<?= Html::a(($model ? "Редактировать" : "Добавить"), ["/abiturient/individual-achievements"],
    ["class" => $model ? "btn btn-warning" : "btn btn-success"]) ?>


<div class="row">
    <div class="col-md-12">

            <?php

            if ($model) :?>

                <p><strong>Уже добавлено:</p>

                <?php foreach ($model as $individual) : ?>
                    <p>
                        <?= $individual->dictIndividualAchievement->name ?>
                        - <?= $individual->dictIndividualAchievement->mark ?> балл(-а,-ов)
                    </p>

                <?php endforeach; endif; ?>
        </div>
    </div>
</div>
