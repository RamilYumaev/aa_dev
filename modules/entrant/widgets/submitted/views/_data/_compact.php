<?php
use yii\helpers\Html;
use modules\entrant\helpers\PostDocumentHelper;
/* @var $this yii\web\View */
/* @var $userCg yii\db\BaseActiveRecord */
?>
<table class="table table-bordered">
    <tr>
        <th>#</th>
        <th>Факультет</th>
        <th>Направление подготовки</th>
        <th></th>
    </tr>
    <?php foreach ($userCg as $key => $cg) /* @var $cg dictionary\models\DictCompetitiveGroup */ :?>
        <tr>
            <td><?= ++$key ?></td>
            <td><?= $cg->faculty->full_name ?></td>
            <td><?= $cg->specialty->code." ".$cg->specialty->name ?></td>
            <td><?= Html::a('Скачать', '#', ['class' => 'btn btn-large btn-primary'])?></td>
        </tr>
    <?php endforeach; ?>
</table>
