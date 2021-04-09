<?php
/* @var  $question testing\models\TestQuestion  */
/* @var  $answer testing\models\TestAttempt  */
?>
<div>
    <h4><?= $question->title ?></h4>
    <p><?= $question->text ?></p>
    <p>Ответы</p>
    <?php foreach ($question->answer as $answer) : ?>
        <?= $answer->name ." - ".$answer->answer_match  ?>  <br />
    <?php endforeach; ?>
</div>

