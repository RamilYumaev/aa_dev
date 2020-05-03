<?php
use yii\helpers\Html;
use modules\entrant\widgets\file\FileWidget;
/* @var $this yii\web\View */
/* @var $statements yii\db\BaseActiveRecord */
/* @var $statement modules\entrant\models\Statement*/
/* @var $isUserSchool bool */
?>
<table class="table table-bordered">
    <?php foreach ($statements as $statement):  ?>
    <tr>
        <td><?= $statement->numberStatement ?>
        <td><?= Html::a('pdf', ['statement/pdf', 'id' =>  $statement->id],
                ['class' => 'btn btn-large btn-danger'])?> <?= FileWidget::widget(['record_id' => $statement->id, 'model' => \modules\entrant\models\Statement::class ]) ?> </td>
    </tr>
    <?php endforeach; ?>
</table>