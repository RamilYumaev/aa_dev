<?php
use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\FileHelper;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;
/* @var $this yii\web\View */
/* @var $others yii\db\BaseActiveRecord */
/* @var $other modules\entrant\models\OtherDocument */
/* @var $statementCg modules\entrant\models\StatementCg*/
/* @var $isUserSchool bool */
?>
<table class="table table-bordered">
    <h3>Прочие документы</h3>
    <tr>
        <th>Наименование</th>
        <th>Данные</th>
        <th>Примечание</th>
        <th></th>
    </tr>
    <?php foreach($others as $other) :?>
        <tr class="<?= BlockRedGreenHelper::colorTableBg($other->countFiles(), FileHelper::listCountModels()[$other::className()], true) ?>">
        <td><?= $other->typeName ?></td>
        <td><?= $other->otherDocumentFull ?></td>
            <td><?= $other->noteOrTypeNote ?></td>
        <td><?= FileWidget::widget(['record_id' => $other->id, 'model' => $other::className() ]) ?>
            <?= FileListWidget::widget(['record_id' => $other->id, 'model' =>  $other::className(), 'userId' => $other->user_id ]) ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>