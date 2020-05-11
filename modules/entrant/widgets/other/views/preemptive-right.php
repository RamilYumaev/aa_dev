<?php
use modules\dictionary\helpers\DictDefaultHelper;
use yii\helpers\Html;
use modules\entrant\helpers\OtherDocumentHelper;

/* @var $this yii\web\View */
/* @var $user_id integer */
?>
<div class="row">
    <div class="col-md-12">
        <h4>Преимущественное право</h4>
        <table class="table table-bordered">
            <tr>
                <th>Приоритет</th>
                <th>Категории, имеющие ПП</th>
                <th></th>
            </tr>
            <?php foreach (DictDefaultHelper::preemptiveRightList() as $key => $value): ?>
                <tr>
                    <td><?= $key ?></td>
                    <td><?= $value ?></td>
                    <td><?= Html::a(Html::tag("span", "",
                            ["class" => "glyphicon glyphicon-plus-sign"]),
                            ["preemptive-right/create", "typeId" => $key],
                            ["class" => "btn btn-success",
                                'data-pjax' => 'w0', 'data-toggle' => 'modal',
                                'data-target' => '#modal', 'data-modalTitle' => 'Добавить']); ?>
                        <?= OtherDocumentHelper::preemptiveRightExits($user_id) ?  Html::a(Html::tag("span", "",
                            ["class" => "glyphicon glyphicon-briefcase"]),
                            ["preemptive-right/add", "typeId" => $key],
                            ["class" => "btn btn-primary",
                                'data-pjax' => 'w1', 'data-toggle' => 'modal',
                                'data-target' => '#modal', 'data-modalTitle' => 'Добавить']) :""; ?>
                    </td>
                </tr>
                <?php foreach (OtherDocumentHelper::preemptiveRightUser($user_id, $key) as $item):
                    /* @var $item \modules\entrant\models\OtherDocument */?>
                    <tr class="success">
                        <td colspan="2"><?= $item->otherDocumentFull ?> (<?= $item->typeName ?>)</td>
                        <td><?= Html::a(Html::tag("span", "",
                                ["class" => "glyphicon glyphicon-minus"]),
                                ["preemptive-right/remove", "otherId" =>$item->id, "typeId" => $key],
                                ["class" => "btn btn-danger"]); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </table>
    </div>
</div>