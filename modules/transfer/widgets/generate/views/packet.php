<?php
use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\FileHelper;
use modules\transfer\widgets\file\FileWidget;
use modules\transfer\widgets\file\FileListWidget;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $documents yii\db\BaseActiveRecord */
/* @var $other modules\transfer\models\PacketDocumentUser */
/* @var $ia bool */
?>
<div class="panel panel-default">
    <div class="panel-heading"><h4><?= 'Скан-копии'?></h4></div>
    <div class="panel-body">
        <table class="table table-bordered">
            <tr>
                <th>Наименование</th>
            </tr>
            <?php foreach($documents as $other) :?>
                <tr class="<?= BlockRedGreenHelper::colorTableBg($other->countFiles(), FileHelper::listCountModels()[$other::className()], true) ?>">
                    <td><?= $other->typeName ?></td>
                    <?php if (!$other->isBook() && $other->isNullData()) :?>
                        <td><?= Html::a('Добавить данные',
                                ['add', 'id' => $other->id], ['class'=> 'btn btn-info','data-pjax' => 'w0'.$other->id, 'data-toggle' => 'modal',
                                    'data-target' => '#modal', 'data-modalTitle' => $other->typeNameR ]); ?></td>
                    <?php else :?>
                        <td><?= FileWidget::widget(['record_id' => $other->id, 'model' => $other::className() ]) ?><br />
                            <?= Html::a('Редактировать данные',
                                ['add', 'id' => $other->id], ['class'=> 'btn btn-warning','data-pjax' => 'w0'.$other->id, 'data-toggle' => 'modal',
                                    'data-target' => '#modal', 'data-modalTitle' => $other->typeNameR ]); ?></td>
                    <?php endif; ?>
                </tr>
                <tr>
                    <td colspan="<?=2 ?>"> <?= FileListWidget::widget(['record_id' => $other->id, 'model' =>  $other::className(), 'userId' => $other->user_id ]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>