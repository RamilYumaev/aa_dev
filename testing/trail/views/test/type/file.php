<?php
use yii\helpers\Html;
use testing\helpers\TestQuestionHelper;
use kartik\file\FileInput;
/* @var $quent testing\models\TestResult */
$maxFileSize = TestQuestionHelper::FILE_VALIDATE_RULES[$quent->question->file_type_id]['maxSize'] / 1024;
?>
<?=  $quent->question->text ?>
<?php if ($quent->getUploadedFileUrl('result')): ?>
    <?= Html::a('Ваш файл',$quent->getUploadedFileUrl('result'))?>
<?php else: ?>
    <p>Загрузите файл: </p>
<?php endif; ?>
<?= FileInput::widget([
    'name' => 'AnswerAttempt[file]',
    'language'=> 'ru',
    'options'=> ['name' => 'AnswerAttempt[file]'],
    'pluginOptions'=>[
        'maxFileCount' => 1,
        'allowedFileExtensions'=>TestQuestionHelper::FILE_VALIDATE_RULES[$quent->question->file_type_id]['extensions'],
        'maxFileSize' => $maxFileSize,
    ],
]);?>
<p><?=implode(", ", TestQuestionHelper::FILE_VALIDATE_RULES[$quent->question->file_type_id]['extensions'])?> </p>

