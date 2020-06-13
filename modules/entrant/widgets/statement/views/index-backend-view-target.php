<?php

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\widgets\file\FileListBackendWidget;
use yii\helpers\Html;
use modules\entrant\widgets\file\FileListWidget;


/* @var $this yii\web\View */
/* @var $statement modules\entrant\models\Statement*/
/* @var $statementCg modules\entrant\models\StatementCg*/
/* @var $isUserSchool bool */
?>
<?php  Box::begin(
    [
        "header" =>"Заявление  №". $statement->numberStatement,
        "type" => Box::TYPE_INFO,
        "filled" => true,]) ?>
    <p>Заявление  №<?= $statement->numberStatement ?>
        <?= $statement->faculty->full_name ?>/
        <?= $statement->speciality->codeWithName ?>/
        <?= $statement->eduLevel ?>/
        <?= $statement->specialRight ?>

        <?= Html::a('Скачать заявление', ['statement/pdf', 'id' =>  $statement->id],
    ['class' => 'btn btn-large btn-warning'])?>

                 <span class="label label-<?= StatementHelper::colorName($statement->status)?>">
                        <?=$statement->statusNameJob?> $statement->status</span>
    </p>

<table class="table table-bordered">
    <tr>
        <th>Образовательные программы</th>
    </tr>
    <?php foreach ($statement->statementCg as $statementCg): ?>
        <tr>
            <td><?= $statementCg->cg->fullName ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php Box::end() ?>
