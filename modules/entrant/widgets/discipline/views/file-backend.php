<?php

use backend\widgets\adminlte\Box;
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
<?php Box::begin(
    [
        "header" => "Централизованное тестирование",
        "type" => Box::TYPE_PRIMARY,
        "filled" => true,]) ?>
<?php foreach ($all as $model): ?>
<table class="table table-bordered">
    <tr>
        <td>
            <?= $model->dictDisciplineSelect->ct->name ?>
        </td>
    </tr>
</table>
    <?= FileListWidget::widget([ 'view'=>'list-backend', 'record_id' => $model->id, 'model' =>  $model::className(), 'userId' => $model->user_id]) ?>
<?php endforeach;
Box::end();
?>