<?php

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;
use dictionary\helpers\DictCompetitiveGroupHelper;
/* @var $this yii\web\View */
/* @var $statementIa modules\entrant\models\StatementIndividualAchievements*/
/* @var $stIa modules\entrant\models\StatementIa */
/* @var $isUserSchool bool */
?>
<?php  Box::begin(
    [
        "header" =>"Заявления об учете индивидуальных достижений №". $statementIa->numberStatement,
        "type" => Box::TYPE_INFO,
        "filled" => true,]) ?>
<p><?= Html::a('Скачать заявление', ['statement-individual-achievements/pdf', 'id' =>  $statementIa->id],
    ['class' => 'btn btn-warning'])?></p>
<?= FileListWidget::widget([ 'view'=> 'list-backend', 'record_id' => $statementIa->id, 'model' => \modules\entrant\models\StatementIndividualAchievements::class, 'userId' =>$statementIa->user_id ]) ?>


<?php  Box::begin(
    [
        "header" =>"Приложение к заявлению №". $statementIa->numberStatement,
        "type" => Box::TYPE_WARNING,
        "filled" => true,]) ?>
<?php foreach ($statementIa->statementIa as $key => $stIa):  ?>
<table class="table table-bordered">
    <tr>
        <th>#</th>
        <th>Наименование</th>
    </tr>
    <tr>
        <td><?= ++$key ?>.</td>
        <td><?= $stIa->dictIndividualAchievement->name ?></td>
    </tr>
</table>
    <?php  Box::begin(
        [
            "header" =>$stIa->userIndividualAchievements->dictOtherDocument->typeName,
            "type" => Box::TYPE_DANGER,
            "filled" => true,]) ?>
    <?= FileListWidget::widget([ 'view'=> 'list-backend', 'record_id' => $stIa->userIndividualAchievements->dictOtherDocument->id, 'model' => \modules\entrant\models\OtherDocument::class, 'userId' =>$statementIa->user_id ]) ?>

<?php Box::end(); endforeach; ?>
<?php Box::end() ?>
