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
                <table class="table  table-bordered">
                    <tr>
                        <th>Наименование</th>
                        <th>Балл</th>
                        <th>Данные документа</th>
                    </tr>
                <?php foreach ($model as $individual) : ?>
                    <tr>
                        <td><?= $individual->dictIndividualAchievement->name ?></td>
                        <td><?= $individual->dictIndividualAchievement->mark ?></td>
                        <td><?=  $individual->dictOtherDocument->otherDocumentFull; ?></td>
                    </tr>
                <?php endforeach; endif; ?>
                </table>
        </div>
    </div>
</div>
