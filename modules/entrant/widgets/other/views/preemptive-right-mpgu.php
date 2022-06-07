<?php

use backend\widgets\adminlte\Box;
use modules\dictionary\helpers\DictDefaultHelper;
use modules\entrant\helpers\OtherDocumentHelper;
use modules\entrant\helpers\PreemptiveRightHelper;
use modules\entrant\widgets\file\FileListBackendWidget;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model yii\db\BaseActiveRecord */
/* @var $userId  integer */

?>
<?php Box::begin(
    ["header" => "Преимущественное право", "type" => Box::TYPE_PRIMARY,
        "collapsable" => true,
    ]
)

?>
<?php if ($model): ?>
    <table class="table table-bordered">
        <tr>
            <th>Приоритет</th>
            <th>Категории, имеющие ПП</th>
        </tr>
        <?php foreach ($model as $pp) : ?>
            <tr>
                <td><?= $pp->type_id ?></td>
                <td><?= DictDefaultHelper::preemptiveRightName($pp->type_id) ?></td>
                <td><?= Html::tag('span', Html::encode(OtherDocumentHelper::preemptiveRightUserStatusCount($userId, $pp->type_id)), ['class' => 'label label-default']) .
                    Html::tag('span', Html::encode(OtherDocumentHelper::preemptiveRightUserStatusCount($userId, $pp->type_id, PreemptiveRightHelper::DANGER)),
                        ['class' => 'label label-danger']).  Html::tag('span', Html::encode(OtherDocumentHelper::preemptiveRightUserStatusCount($userId, $pp->type_id, PreemptiveRightHelper::SUCCESS)),
                        ['class' => 'label label-success']); ?></td>
            </tr>
            <?php foreach (OtherDocumentHelper::preemptiveRightUser($userId, $pp->type_id) as $key => $item):
                /* @var $item \modules\entrant\models\OtherDocument */
                $ppOne = $item->preemptiveRightsTypeOne($pp->type_id);
                ?>
                <tr>
                    <td colspan="2"> Данные документа: <?= $item->otherDocumentBackendFull ?> (<?= $item->typeName ?>)</td>
                    <td> <?php if(!$ppOne->statue_id)  : ?>
                        <?= Html::a(Html::tag("span", "",
                            ["class" => "glyphicon glyphicon-check"]),
                            ["preemptive-right/success", "otherId" =>$item->id, "typeId" => $pp->type_id],
                            ["class" => "btn btn-success", 'data' =>['confirm' => 'Вы уверены, что хотите принять?', 'method' => 'post']]); ?>
                        <?=   Html::a(Html::tag("span", "",
                            ["class" => "glyphicon glyphicon-remove"]),
                            ["preemptive-right/danger", "otherId" =>$item->id, "typeId" =>$pp->type_id],
                            ["class" => "btn btn-danger", 'data' =>['confirm' => 'Вы уверены, что хотите отклонить?', 'method' => 'post']]); ?>
                        <?php else: ?>
                        <?= Html::tag('span', Html::encode(PreemptiveRightHelper::statusName($ppOne->statue_id)),
                                ['class' => 'label label-'.PreemptiveRightHelper::colorName($ppOne->statue_id)]) ?>
                    <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <?= FileListBackendWidget::widget([ 'record_id' => $item->id, 'model' => \modules\entrant\models\OtherDocument::class, 'userId' =>$userId ]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </table>
<?php endif; Box::end(); ?>
