<?php

use backend\widgets\adminlte\Box;
use \yii\helpers\Html;

/**
 * @var $model \modules\entrant\models\UserIndividualAchievements
 */

?>
    <?php Box::begin(
        ["header" => "Индивидуальные достижения", "type" => Box::TYPE_WARNING,
            "collapsable" => true,
        ]
    )
    ?>

            <?php

            if ($model) :?>

                <p><strong>Уже добавлено:</p>

                <?php foreach ($model as $individual) : ?>
                    <p>
                        <?= $individual->dictIndividualAchievement->name ?>
                        - <?= $individual->dictIndividualAchievement->mark ?> балл(-а,-ов)
                    </p>

                <?php endforeach; endif; Box::end()?>
