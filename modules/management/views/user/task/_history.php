<?php
/* @var $this yii\web\View */

use yii\helpers\ArrayHelper;

/* @var $task modules\management\models\Task */
/* @var $history modules\management\models\HistoryTask */

?>
<?php foreach ($task->getHistoryTasks()->all() as $history): ?>
    <div class="box box-primary">
        <div class="box-header">
            <h4><?= (!$history->getAfterData() ? "Создано": "Обновлено"). " ". $history->profile->fio." ". $history->created_at ?></h4>
        </div>
        <?php if($history->getAfterData()): ?>
        <div class="box-body">
            <table class="table">
                <tr>
                    <th style="width:50%">Значение</th>
                    <th>Было</th>
                    <th>Стало</th>
                </tr>
                <?php foreach ($history->getAfterData() as $key => $value) :?>
                    <?php  if($history->isIdenticalValue($key, $value)) continue ?>
                    <tr>
                        <td><?= $task->getAttributeLabel($key) ?></td>
                        <td><?= $history->attributesValue($history->getBefore($key))[$key]?></td>
                        <td><?= $history->attributesValue($value)[$key] ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>


