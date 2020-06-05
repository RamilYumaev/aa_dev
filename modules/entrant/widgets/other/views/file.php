<?php
use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\FileHelper;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $others yii\db\BaseActiveRecord */
/* @var $other modules\entrant\models\OtherDocument */
/* @var $statementCg modules\entrant\models\StatementCg*/
/* @var $isUserSchool bool */
?>
<div class="panel panel-default">
    <div class="panel-heading"><h4>Прочие документы</h4></div>
    <div class="panel-body">
        <table class="table table-bordered">
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
                    <?php if(!$other->files) :?>
                <td><?= \yii\helpers\Html::a("Удалить",
                        ['other-document/delete', 'id'=> $other->id ], ['class' => "btn btn-danger", 'data'=>['method'=>
                            'post', 'confirm' => 'Вы уверены, что хотите удалить данный прочий документ?']])?>
                </td><?php endif; ?>
                    <td>
                        <?= $other->type_note == \modules\entrant\helpers\OtherDocumentHelper::STATEMENT_TARGET ?
                          Html::a('Скачать заявление', ['other-document/pdf', 'id' =>  $other->id],
                                            ['class' => 'btn btn-large btn-warning'])
                            : "";

                        ?>
                    <?= FileWidget::widget(['record_id' => $other->id, 'model' => $other::className() ]) ?></td>
            </tr>
            <tr>
              <td colspan="<?= $other->files? 4:5 ?>"> <?= FileListWidget::widget(['record_id' => $other->id, 'model' =>  $other::className(), 'userId' => $other->user_id ]) ?>
                </td> </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>