<?php
/* @var $this yii\web\View */
/* @var $moderation common\moderation\models\Moderation */

\backend\assets\modal\ModalAsset::register($this)
?>
<div class="box box-primary">
    <div class="box-body">
        <table class="table">
            <tr>
                <th style="width:50%">Значение</th>
                <th>Было</th>
                <th>Стало</th>
            </tr>
            <?php foreach ($moderation->getAfterData() as $key => $value) :?>
                <tr>
                    <td><?= $moderation->getModel()->getAttributeLabel($key) ?></td>
                    <td><?= $moderation->getModel()->moderationValue($key, $moderation->getBefore($key)) ?></td>
                    <td><?= $moderation->getModel()->moderationValue($key, $value) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="box-footer">
        <?php if ($moderation->isStatusNew()) : ?>
        <?= \yii\helpers\Html::a('Принять', ['take', 'id' => $moderation->id], ['class'=> 'btn btn-success'])?>
        <?= \yii\helpers\Html::a('Отклонить', ['reject', 'id' => $moderation->id], ['class'=> 'btn btn-danger', 'data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' =>'Причина отклонения'  ])?>
        <?php endif;?>
    </div>
</div>



