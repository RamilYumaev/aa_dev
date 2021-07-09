<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\FileHelper;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;
use yii\helpers\Html;

/* @var $model modules\entrant\models\Agreement */
?>
    <h3>Скан договора о целевом обучении</h3>
<table class="table table-bordered">
    <tr>
        <th>Наименование договора</th>
        <th>
            <?php if ($swichUserId = \Yii::$app->session->get('user.idbeforeswitch')) : ?>
                <?php if (Yii::$app->authManager->getAssignment('dev', $swichUserId)): ?>
                    <?= Html::a('Удалить', ['agreement/delete'], ['class' => 'btn btn-danger', 'data-confirm' => 'Вы уверены, что хотите удалить договор?']) ?>
                <?php endif; ?>
            <?php endif; ?>
            <?= FileWidget::widget(['record_id' => $model->id, 'model' =>$model::className() ]) ?>
        </th>
    </tr>
    <tr class="<?= BlockRedGreenHelper::colorTableBg($model->countFiles(), FileHelper::listCountModels()[$model::className()], true) ?>">
        <td>
            <p><?=  "Заказчик: ".($model &&  $model->organization ? $model->fullOrganization : 'нет данных') ?></p>
            <p><?=  "Работодатель: ".($model && $model->organizationWork ? $model->fullOrganizationWork : 'нет данных')  ?></p>
            <?= $model->documentFull ?>, <?= $model->organization->name ?>
        </td>
        <td>
            <?= FileListWidget::widget(['record_id' => $model->id, 'model' => $model::className(),  'userId' => $model->user_id]) ?>
        </td>
    </tr>
</table>