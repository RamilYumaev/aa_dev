<?php
/* @var  $question modules\exam\models\ExamQuestion */
/* @var  $answer modules\exam\models\ExamAnswer */
?>
<div>
    <h4><?= $question->title ?></h4>
    <p><?= $question->text ?></p>
    <p>Ответы</p>
    <?php foreach ($question->answer as $answer) : ?>
        <?= $answer->name ." - ".$answer->answer_match  ?>  <br />
    <?php endforeach; ?>
</div>

