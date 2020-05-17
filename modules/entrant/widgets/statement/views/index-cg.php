<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;
use dictionary\helpers\DictCompetitiveGroupHelper;
/* @var $this yii\web\View */
/* @var $statementsCg yii\db\BaseActiveRecord */
/* @var $statement modules\entrant\models\StatementCg*/
/* @var $consent modules\entrant\models\StatementConsentCg*/
/* @var $isUserSchool bool */
?>
<h3>Заявления о зачислении</h3>
<table class="table table-bordered">
    <tr>
        <th>Образовательные программы</th>
        <th></th>
    </tr>
    <?php foreach ($statementsCg as $statement):  ?>
        <tr >
            <td><?= $statement->cg->fullName ?> <?= Html::a('Сформиировать заявление', ['statement-consent-cg/create',
                    'id' => $statement->id], ['class' => 'btn btn-info',]) ?>
                <table class="table">
                    <?php foreach ($statement->statementConsent as $consent): ?>
                        <tr class="<?= BlockRedGreenHelper::colorTableBg($consent->countFiles(), $consent->count_pages) ?>">
                            <td><?= $consent->id ?></td>
                            <td><?= Html::a('Скачать заявление', ['statement-consent-cg/pdf', 'id' =>  $consent->id],
                                    ['class' => 'btn btn-large btn-warning'])?>
                                <?= FileWidget::widget(['record_id' => $consent->id, 'model' => \modules\entrant\models\StatementConsentCg::class ]) ?>

                                <?= FileListWidget::widget(['record_id' => $consent->id, 'model' => \modules\entrant\models\StatementConsentCg::class ]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>