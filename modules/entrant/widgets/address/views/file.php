<?php
use yii\helpers\Html;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;
/* @var $this yii\web\View */
/* @var $addresses yii\db\BaseActiveRecord */
/* @var $address modules\entrant\models\Address */
/* @var $statementCg modules\entrant\models\StatementCg*/
/* @var $isUserSchool bool */
?>
<table class="table table-bordered">
    <tr>
        <th>Скан страницы паспорта с отметкой о регистрации или скан временной регистрации</th>
        <th>Тип</th>
        <th></th>
    </tr>
    <?php foreach($addresses as $address) :?>
    <tr>
        <td><?= $address->addersFull ?></td>
        <td><?= $address->typeName ?></td>
        <td><?= FileWidget::widget(['record_id' => $address->id, 'model' => $address::className() ]) ?>
            <?= FileListWidget::widget(['record_id' => $address->id, 'model' =>  $address::className() ]) ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>