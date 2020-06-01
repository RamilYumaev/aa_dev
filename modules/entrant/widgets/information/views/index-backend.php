<?php

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use dictionary\helpers\DictCompetitiveGroupHelper;

/* @var $this yii\web\View */
/* @var $additional_information modules\entrant\models\AdditionalInformation */

?>
<?php Box::begin(
    ["header" => "Дополнительная информация:", "type" => Box::TYPE_PRIMARY,
        "collapsable" => true,
    ]
)
?>
<?php if ($additional_information) : ?>
    <?php
    $columns = [
        'resource',
        'voz',
        'chernobyl',
        'mpguTraining'

    ];
    ?>
    <?php if (DictCompetitiveGroupHelper::formOchExistsUser($additional_information->user_id)): ?>
        <?php array_push($columns, 'hostel') ?>
    <?php endif; ?>
    <?php if (DictCompetitiveGroupHelper::eduSpoExistsUser($additional_information->user_id)): ?>
        <?php array_push($columns, 'mark_spo') ?>
    <?php endif; ?>
    <?= DetailView::widget([
        'options' => ['class' => 'table table-bordered detail-view'],
        'model' => $additional_information,
        'attributes' => $columns
    ]) ?>
            <?php endif; ?>
<?php Box::end();
