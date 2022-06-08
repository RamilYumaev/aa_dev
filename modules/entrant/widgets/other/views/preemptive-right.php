<?php
use modules\dictionary\helpers\DictDefaultHelper;
use yii\helpers\Html;
use modules\entrant\helpers\OtherDocumentHelper;

/* @var $this yii\web\View */
/* @var $user_id integer */
?>
<div class="row">
    <div class="col-md-12">
        <h1>Преимущественное право</h1>
        <div class="row mb-20">
            <div class="col-md-12">
                <?= Html::img("/img/cabinet/pp_plus.png", ["width"=>"23px", "height"=> "20px"]) ?>
                - добавление нового документа, которого нет в системе.<br/><br/>
                <?= Html::img("/img/cabinet/pp_case.png", ["width"=>"23px", "height"=> "20px"])?>
                - привязка документа из ранее добавленных в систему в блоке "Прочие документы" персональной
                карточки поступающего.
            </div>
        </div>
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
                            ["preemptive-right/create", "id" => $key],
                            ["class" => "btn btn-success",]); ?>
                        <?= OtherDocumentHelper::preemptiveRightExits($user_id) ?  Html::a(Html::tag("span", "",
                            ["class" => "glyphicon glyphicon-briefcase"]),
                            ["preemptive-right/add", "id" => $key],
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
                                ["preemptive-right/remove", "otherId" =>$item->id, "id" => $key],
                                ["class" => "btn btn-danger"]); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </table>
    </div>
</div>