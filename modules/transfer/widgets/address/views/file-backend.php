<?php

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use modules\entrant\helpers\FileHelper;
use modules\transfer\widgets\file\FileWidget;
use modules\transfer\widgets\file\FileListWidget;
/* @var $this yii\web\View */
/* @var $addresses yii\db\BaseActiveRecord */
/* @var $address modules\entrant\models\Address */
/* @var $isUserSchool bool */
?>
<?php Box::begin(
    [
        "header" => "Скан страницы паспорта с отметкой о регистрации или скан временной регистрации",
        "type" => Box::TYPE_PRIMARY,
        "filled" => true,]) ?>
<?php foreach($addresses as $address) :?>
<table class="table table-bordered">
    <tr>
        <th>Адрес</th>
        <th>Тип</th>
    </tr>
    <tr>
        <td><?= $address->addersFull ?></td>
        <td><?= $address->typeName ?></td>
    </tr>

</table>
    <?= FileListWidget::widget([ 'view'=>'list-backend', 'record_id' => $address->id, 'model' =>  $address::className(), 'userId' => $address->user_id]) ?>
<?php endforeach;
Box::end();
?>