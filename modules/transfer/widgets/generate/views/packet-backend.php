<?php
use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\FileHelper;
use modules\transfer\widgets\file\FileWidget;
use modules\transfer\widgets\file\FileListWidget;
use operator\widgets\adminlte\Box;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $documents yii\db\BaseActiveRecord */
/* @var $other modules\transfer\models\PacketDocumentUser */
/* @var $ia bool */
?>
<?php Box::begin(
    [
        "header" => "Скан-копии",
        "type" => Box::TYPE_PRIMARY,
        "icon" => 'passport',
        "filled" => true,]) ?>
        <table class="table table-bordered">
            <?php foreach($documents as $other) :?>
                <tr>
                    <td width="50%"><?= $other->typeName ?> <br/>
                        <br/>
                        <strong><?= $other->data ?></strong></td>
                <td><?= FileListWidget::widget([ 'view'=>'list-backend', 'record_id' => $other->id, 'model' =>  $other::className(), 'userId' => $other->user_id]) ?>
                    </td></tr>
            <?php endforeach; ?>
        </table>
<?php Box::end() ?>