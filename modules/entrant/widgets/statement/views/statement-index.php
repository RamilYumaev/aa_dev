<?php
/* @var $this yii\web\View */
/* @var $statements yii\db\BaseActiveRecord */
/* @var $statement modules\entrant\models\Statement */

/* @var $statementCg modules\entrant\models\StatementCg */

/* @var $isAccepted bool */
/* @var $isContract bool */

use modules\entrant\helpers\StatementHelper;
use \yii\bootstrap\Collapse;
use yii\helpers\Html;
use \modules\entrant\models\Anketa;
use \modules\entrant\helpers\CategoryStruct;

$anketa = \Yii::$app->user->identity->anketa();
?>
<?php if ($statements): ?>
<?php $isNotTpgu = $anketa->category_id !== \modules\entrant\helpers\CategoryStruct::TPGU_PROJECT;?>
    <div class="panel panel-default">
        <div class="panel-heading fs-20">Заявления об участии в конкурсе
            <?=Html::a("Добавить", "/abiturient/anketa/step2")?>
            <?= $isAccepted ? Html::a("Отозвать","/abiturient/post-document/statement-rejection") : ""?>
                <?= ($isContract && $isNotTpgu) ? Html::a("Договор на платное обучение","/abiturient/post-document/agreement-contract",
                    ['class'=>'pull-right btn btn-info']) : "" ?>
        </div>
        <div class="panel-body">
            <?php
            $result = [];
            $resultFinish = [];
            $array = [];
            foreach ($statements as $statement) {
                $resultData = "<table class='table table-bordered'>";
                $resultData .= "<th>Образовательные программы</th>";
                foreach ($statement->statementCg as $statementCg) {
                    $resultData .= "<tr>";
                    $resultData .= "<td>";
                    $resultData .= $statementCg->cg->fullName. ($statement->isStatusAccepted() && $statementCg->status_id ? " <span class=\"label label-danger\">Отозван</span>" : "");
                    $resultData .= "</td>";
                    $resultData .= "</tr>";
                }
                $resultData .= "</table>";
                $result[] =
                    ['label' => $statement->faculty->full_name . ", <b>" . $statement->speciality->getCodeWithName() . "</b>,<br/>Заявление № "
                        . $statement->numberStatement . " <span class=\"label label-"
                        . StatementHelper::colorName($statement->status) . "\">" . $statement->statusName . "</span> ". ($statement->statementRejection ?
                        "(". "Заявление об отзыве <span class=\"label label-" . StatementHelper::colorName($statement->statementRejection ->status_id) . "\">" . $statement->statementRejection->statusName . "</span>".")" : "").
                         ($statement->message ? "<br/> Причина отклонения: ".  $statement->message :""),
                        ($statement->message ? "<br/> Причина отклонения: ".  $statement->message :""),

                        'content' => $resultData,
                        'contentOptions' => ['class' => 'out']];

            }
            ?>
            <?= Collapse::widget(['encodeLabels' => false, 'items' => $result]); ?>
            <?=  Html::a("Заявление о согласии на зачисление. Добавить", "/abiturient/post-document/consent-rejection",  ['class'=>'pull-right btn btn-success']) ?>
        </div>
    </div>
<?php endif; ?>