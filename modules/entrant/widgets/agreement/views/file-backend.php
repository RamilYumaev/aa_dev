<?php

use backend\widgets\adminlte\Box;
use yii\helpers\Html;

/* @var $cg modules\entrant\models\StatementCg */
/* @var $cgs \yii\db\ActiveRecord */
/* @var $this \yii\web\View */

?>
<?php Box::begin(
    [
        "header" => "Скан договора о целевом обучении",
        "type" => Box::TYPE_INFO,
        "filled" => true,]) ?>
    <table class="table table-bordered">
        <tr>
            <th>Наименование договора</th>
        </tr>
        <tr>
            <td>
                <p><?= "Заказчик: " . ($model && $model->organization ? $model->fullOrganization : 'нет данных') ?></p>
                <p><?= "Работодатель: " . ($model && $model->organizationWork ? $model->fullOrganizationWork : 'нет данных') ?></p>
                <?= $model->documentFull ?>
            </td>
            <td>
                <?= Html::a("Принять", ['communication/export-data-organization', 'agreementId' => $model->id], ['data-method' => 'post', 'id' => 'accept_button', 'class' => 'btn btn-success']) ?>
            </td>
            <td>
                <?= Html::a("Отклонить", ["agreement/message", 'id' => $model->id], ["class" => "btn btn-danger",
                    'data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => 'Причина отклонения']) ?></td>

            </td>
        </tr>
    </table>

<?= Html::a("Выбрать конкусные группы абитуриента", ['clarify-cgs', 'id' => $model->id,],
    ['class' => 'btn btn-info', 'style' => ['margin' => '20px'],
        'data-pjax' => 'w1', 'data-toggle' => 'modal', 'data-target' => '#modal',
        'data-modalTitle' => 'Уточнение конкурсных групп для целевого договора']) ?>

<?= \modules\entrant\widgets\file\FileListBackendWidget::Widget(['view' => 'list-backend',
    'record_id' => $model->id,
    'model' => $model::className(),
    'userId' => $model->user_id]) ?>
<?php Box::end(); ?>

<?php if ($model->statement): ?>
    <?php foreach ($model->statement as $statement): ?>
        <?= \modules\entrant\widgets\statement\StatementBackendWidget::widget(['statement' => $statement]) ?>
    <?php endforeach; endif; ?>