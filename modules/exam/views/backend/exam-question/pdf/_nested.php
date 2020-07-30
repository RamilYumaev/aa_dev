<?php
/* @var  $question modules\exam\models\ExamQuestion */
/* @var  $nested modules\exam\models\ExamQuestionNested */
/* @var  $answer modules\exam\models\ExamAnswerNested */
?>
<div>
    <h4><?= $question->title ?></h4>
    <p><?= $question->text ?></p>
    <?php foreach ($question->questionNested as $nested) : ?>
        <?= $nested->name ?>   <br />
        <?php foreach ($nested->answer as $answer) : ?>
            <?= $answer->name ." - ".($answer->is_correct ? "-правильнй ответ" : "")   ?>  <br />
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>