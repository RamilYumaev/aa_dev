<?php

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;

/* @var $this yii\web\View */
/* @var $statementConsents yii\db\BaseActiveRecord */
/* @var $consent modules\entrant\models\StatementConsentCg*/
/* @var $isUserSchool bool */
?>
<?php  Box::begin(
    [
        "header" =>"Заявление о согласии на зачисление",
        "type" => Box::TYPE_PRIMARY,
        "filled" => true,]) ?>

<?php foreach ($statementConsents as $consent): ?>
    <table class="table">
        <tr>
            <th><?=$consent->statementCg->cg->fullName?></th>
            <td><?= Html::a('Скачать заявление', ['statement-consent-cg/pdf', 'id' =>  $consent->id],
                    ['class' => 'btn btn-large btn-warning'])?>
            </td>
        </tr>
    </table>
    <?= FileListWidget::widget([ 'view'=>'list-backend', 'record_id' => $consent->id,
        'model' => \modules\entrant\models\StatementConsentCg::class, 'userId' => $consent->statementCg->statement->user_id  ]) ?>
<?php endforeach;
Box::end(); ?>
