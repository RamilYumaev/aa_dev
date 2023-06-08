<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;

/* @var $this yii\web\View */
/* @var $statement modules\entrant\models\StatementConsentPersonalData*/
/* @var $isUserSchool bool */
?>
<div class="panel panel-default">
    <div class="panel-heading"><h4>Заявление о согласии на обработку персональных данных</h4></div>
    <div class="panel-body">
        <table class="table table-bordered">
            <tr class="<?= BlockRedGreenHelper::colorTableBg($statement->countFiles(), $statement->count_pages, true) ?>">
                <td><?= Html::a('Скачать заявление', ['statement-personal-data/pdf', 'id' =>  $statement->id],
                        ['class' => 'btn btn-warning'])?> <?= FileWidget::widget(['record_id' => $statement->id, 'model' => \modules\entrant\models\StatementConsentPersonalData::class ]) ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?= FileListWidget::widget(['record_id' => $statement->id, 'model' => \modules\entrant\models\StatementConsentPersonalData::class,  'userId' => $statement->user_id ]) ?>
                </td>
            </tr>
        </table>
    </div>
</div>