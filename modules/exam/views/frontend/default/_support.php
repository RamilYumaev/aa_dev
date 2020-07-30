<?php
use modules\entrant\helpers\StatementHelper;
use dictionary\helpers\DictCompetitiveGroupHelper;
/**
 * @var $anketa modules\entrant\models\Anketa
 * @var $this yii\web\View
 */

$anketa = Yii::$app->user->identity->anketa();
$userId = Yii::$app->user->identity->getId();
?>

<?php if(StatementHelper::statementSuccess($userId, DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR)) : ?>
    https://t.me/joinchat/NO93UQnWOrAk_Gli9_H-Og - для поступающих в бакалавриат
<?php endif;?>
<?php if(StatementHelper::statementSuccess($userId, DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER)) : ?>
    https://t.me/joinchat/NO93URlERkWTRmi0J-qNdg - для поступающих в магистратуру
<?php endif;?>
https://t.me/joinchat/NO93URipPcKHwb3BKTbxVw - для поступающих в аспирантуру
<?php if(StatementHelper::statementSuccess($userId, DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL)) : ?>
<?php endif;?>
<?php if($anketa->isTpgu()) : ?>
<?php endif;?>




https://t.me/joinchat/NO93URuWczS1tNsuXOA3xg - для абитуриентов, поступающих по соглашению МПГУ-ТГПУ.
<div>
            <h3>Группы технической поддержки</h3>
            <p>

            </p>
        </div>