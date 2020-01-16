<?php
use yii\helpers\Html;
use testing\helpers\TestQuestionHelper;
use kartik\file\FileInput;
/* @var $quent testing\models\TestResult */
?>
<?= TestQuestionHelper::questionTextName($quent->question_id) ?>
<?php if ($quent->getUploadedFileUrl('result')): ?>
    <?= Html::a('Ваш файл',$quent->getUploadedFileUrl('result'))?>
<?php else: ?>
    <p>Загрузите файл: </p>
<?php endif; ?>
<?= FileInput::widget([
    'name' => 'AnswerAttempt[file]',
    'options'=> ['name' => 'AnswerAttempt[file]'],
    'pluginOptions'=>[
        'maxFileCount' => 1,
        'allowedFileExtensions'=>TestQuestionHelper::FILE_VALIDATE_RULES[TestQuestionHelper::questionTypeFile(
                $quent->question_id)]['extensions'],
        'maxFileSize' => [TestQuestionHelper::FILE_VALIDATE_RULES[TestQuestionHelper::questionTypeFile(
            $quent->question_id)]['maxSize']],
    ],
]);?>
<p><?=implode(", ", TestQuestionHelper::FILE_VALIDATE_RULES[TestQuestionHelper::questionTypeFile(
        $quent->question_id)]['extensions'])?> </p>

