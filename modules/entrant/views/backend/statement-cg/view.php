<?php

/* @var $this yii\web\View */

use backend\widgets\adminlte\Box;

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



<?php Box::end() ?>