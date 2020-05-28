<?php

use backend\widgets\adminlte\Box;
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
<?php Box::begin(
    [
        "header" => "Прочие документы",
        "filled" => true,]) ?>
<?php foreach($others as $other) :?>
<table class="table table-bordered">
    <tr>
        <th>Наименование</th>
        <th>Данные</th>
        <th>Примечание</th>
    </tr>
    <tr>
        <td><?= $other->typeName ?></td>
        <td><?= $other->otherDocumentFull ?></td>
        <td><?= $other->noteOrTypeNote ?></td>
    </tr>
</table>
    <?= FileListWidget::widget([ 'view'=>'list-backend','record_id' => $other->id, 'model' =>  $other::className(), 'userId' => $other->user_id ]) ?>
<?php endforeach;  Box::end(); ?>