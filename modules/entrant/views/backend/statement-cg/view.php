<?php

/* @var $this yii\web\View */

use backend\widgets\adminlte\Box;
use backend\widgets\adminlte\Callout;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\widgets\file\FileListWidget;
use yii\helpers\Html;

/* @var $cg dictionary\models\DictCompetitiveGroup */
/* @var $stCg \modules\entrant\models\StatementCg */
/* @var $statementCg \yii\db\BaseActiveRecord */

$this->title = $cg->fullName;
$this->params['breadcrumbs'][] = $this->title;
?>

<?php foreach ($statementCg->all() as $stCg)?>
<?php Box::begin(
    [
        "header" => $stCg->statement->profileUser->fio,
        "type" => Box::TYPE_SUCCESS,
        "filled" => true,]) ?>
    <?php if ($stCg->statementConsent):?>
    <?php Callout::begin(["type" =>Callout::TYPE_INFO]); ?>
    <h4>Заявление о согласии на зачисление</h4>
    <?php Callout::end(); ?>

    <?php foreach ($stCg->statementConsent as $consent): ?>
    <table class="table">
        <tr>
            <th><span class="label label-<?= StatementHelper::colorName($consent->status)?>">
                        <?=$consent->statusNameJob ?></span></th>
            <td><?= Html::a('Скачать заявление', ['statement-consent-cg/pdf', 'id' =>  $consent->id],
                    ['class' => 'btn btn-large btn-warning'])?>
            </td>
        </tr>
    </table>
    <?= FileListWidget::widget([ 'view'=>'list-backend', 'record_id' => $consent->id,
        'model' => \modules\entrant\models\StatementConsentCg::class, 'userId' => $consent->statementCg->statement->user_id  ]) ?>
        <?php if($consent->statementCgRejection): ?>
            <table class="table">
                <tr>
                    <th><span class="label label-<?= StatementHelper::colorName($consent->statementCgRejection->status_id)?>">
                        <?= $consent->statementCgRejection->statusNameJob ?></span></th>
                    <td><?= Html::a('Скачать заявление', ['statement-consent-cg/pdf', 'id' =>  $consent->statementCgRejection->id,],
                            ['class' => 'btn btn-large btn-warning'])?>
                    </td>
                </tr>
            </table>
        <?php Callout::begin(["type" =>Callout::TYPE_WARNING]); ?>
        <h4>Заявление об отзыве согласии на зачисление</h4>
        <?php Callout::end(); ?>
            <?= FileListWidget::widget([ 'view'=>'list-backend',
                'record_id' => $consent->statementCgRejection->id,
                'model' => \modules\entrant\models\StatementRejectionCgConsent::class,
                'userId' => $consent->statementCg->statement->user_id  ]) ?>
        <?php endif; ?>
    <?php  endforeach; endif; ?>
<?php Box::end() ?>