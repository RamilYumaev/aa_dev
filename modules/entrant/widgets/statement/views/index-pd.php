<?php
use yii\helpers\Html;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;
use dictionary\helpers\DictCompetitiveGroupHelper;
/* @var $this yii\web\View */
/* @var $statement modules\entrant\models\StatementConsentPersonalData*/
/* @var $isUserSchool bool */
?>
<h3>Заявления об персональных данных</h3>
<table class="table table-bordered">
    <tr>
        <td><?= Html::a('Скачать заявление', ['statement-personal-data/pdf', 'id' =>  $statement->id],
                ['class' => 'btn btn-warning'])?> <?= FileWidget::widget(['record_id' => $statement->id, 'model' => \modules\entrant\models\StatementConsentPersonalData::class ]) ?>

            <?= FileListWidget::widget(['record_id' => $statement->id, 'model' => \modules\entrant\models\StatementConsentPersonalData::class ]) ?>
        </td>
    </tr>
</table>