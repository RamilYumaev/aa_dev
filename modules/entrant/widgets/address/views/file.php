<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use modules\entrant\helpers\FileHelper;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;
/* @var $this yii\web\View */
/* @var $addresses yii\db\BaseActiveRecord */
/* @var $address modules\entrant\models\Address */
/* @var $statementCg modules\entrant\models\StatementCg*/
/* @var $isUserSchool bool */
?>
<h3>Скан страницы паспорта с отметкой о регистрации или скан временной регистрации</h3>
<table class="table table-bordered">
    <tr>
        <th>Адрес</th>
        <th>Тип</th>
        <th></th>
    </tr>
    <?php foreach($addresses as $address) :?>
    <tr class="<?= BlockRedGreenHelper::colorTableBg($address->countFiles(), FileHelper::listCountModels()[$address::className()]) ?>">
        <td><?= $address->addersFull ?></td>
        <td><?= $address->typeName ?></td>
        <td><?= FileWidget::widget(['record_id' => $address->id, 'model' => $address::className() ]) ?>
            <?= FileListWidget::widget(['record_id' => $address->id, 'model' =>  $address::className() ]) ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>