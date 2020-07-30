<?php
use modules\entrant\helpers\StatementHelper;
use dictionary\helpers\DictCompetitiveGroupHelper;
use yii\helpers\Html;

/**
 * @var $anketa modules\entrant\models\Anketa
 * @var $this yii\web\View
 */

$anketa = Yii::$app->user->identity->anketa();
$userId = Yii::$app->user->identity->getId();
?>
<div>
    <h3>Группа(-ы) технической поддержки</h3>
<?php if(StatementHelper::statementSuccess($userId, DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR)) : ?>
   <?= Html::a('https://t.me/joinchat/NO93UQnWOrAk_Gli9_H-Og') ?> - для поступающих в бакалавриат
<?php endif;?>
<?php if(StatementHelper::statementSuccess($userId, DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER)) : ?>
    https://t.me/joinchat/NO93URlERkWTRmi0J-qNdg - для поступающих в магистратуру
<?php endif;?>
https://t.me/joinchat/NO93URipPcKHwb3BKTbxVw - для поступающих в аспирантуру
<?php if(StatementHelper::statementSuccess($userId, DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL)) : ?>
<?php endif;?>
<?php if($anketa->isTpgu()) : ?>
    https://t.me/joinchat/NO93URuWczS1tNsuXOA3xg - для абитуриентов, поступающих по соглашению МПГУ-ТГПУ.
<?php endif;?>
</div>