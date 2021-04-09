<?php
/* @var  $question testing\models\TestQuestion  */
/* @var  $nested testing\models\QuestionProposition */
/* @var  $answer testing\models\AnswerCloze */
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