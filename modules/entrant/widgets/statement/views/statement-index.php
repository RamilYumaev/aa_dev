<?php
/* @var $this yii\web\View */
/* @var $statements yii\db\BaseActiveRecord */
/* @var $statement modules\entrant\models\Statement */

/* @var $statementCg modules\entrant\models\StatementCg */

use modules\entrant\helpers\StatementHelper;
use \yii\bootstrap\Collapse;

?>
<?php if ($statements): ?>

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
            $resultData .= $statementCg->cg->fullName;
            $resultData .= "</td>";
            $resultData .= "</tr>";
        }
        $resultData .= "</table>";
        $result = [
            ['label' => $statement->faculty->full_name.", ".$statement->speciality->getCodeWithName().",<br/>Заявление № "
                . $statement->numberStatement . " <span class=\"label label-"
                . StatementHelper::colorName($statement->status) . "\">" . $statement->statusName . "</span>",
            'content' => $resultData,
            'contentOptions' => ['class' => 'out']],];

        if(count($array))
        {
            $resultFinish = array_merge($array, $result);
        }
        $array = $result;
    }
    ?>
    <?=Collapse::widget(['encodeLabels' => false, 'items' => $resultFinish]); ?>

<?php endif; ?>