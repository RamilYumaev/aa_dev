<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use modules\entrant\helpers\FileHelper;
use modules\transfer\widgets\file\FileWidget;
use modules\transfer\widgets\file\FileListWidget;
/* @var $this yii\web\View */
/* @var $addresses yii\db\BaseActiveRecord */
/* @var $address modules\entrant\models\Address */
/* @var $statementCg modules\entrant\models\StatementCg*/
/* @var $isUserSchool bool */
?>
<div class="panel panel-default">
    <div class="panel-heading"><h4>Скан страницы паспорта с отметкой о регистрации или скан временной регистрации</h4></div>
    <div class="panel-body">
        <table class="table table-bordered">
            <tr>
                <th>Адрес</th>
                <th>Тип</th>
                <th></th>
            </tr>
            <?php foreach($addresses as $address) :?>
            <tr class="<?= BlockRedGreenHelper::colorTableBg($address->countTransferFiles(), FileHelper::listCountModels()[$address::className()]) ?>">
                <td><?= $address->addersFull ?></td>
                <td><?= $address->typeName ?></td>
                <td><?= FileWidget::widget(['record_id' => $address->id, 'model' => $address::className()]) ?></td>
            </tr>
            <tr>
                <td colspan="3">  <?= FileListWidget::widget(['record_id' => $address->id, 'model' =>  $address::className(), 'userId' => $address->user_id]) ?> </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>