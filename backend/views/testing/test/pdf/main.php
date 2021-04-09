<?php
/* @var $questions \yii\db\ActiveRecord */

/* @var  $question testing\models\TestQuestion */
use testing\helpers\TestQuestionHelper;
?>
<?php foreach ($questions as  $question) : ?>
    <?php switch ($question->type_id):
         case TestQuestionHelper::TYPE_SELECT_ONE: ?>
            <?= $this->render('_one', ['question' => $question]) ?>
            <?php break; ?>
        <?php case TestQuestionHelper::TYPE_MATCHING: ?>
            <?= $this->render('_matching', ['question'=>$question]) ?>
            <?php break; ?>
        <?php case TestQuestionHelper::TYPE_ANSWER_SHORT: ?>
            <?= $this->render('_answer_short', ['question'=>$question]) ?>
            <?php break; ?>
        <?php case TestQuestionHelper::TYPE_SELECT: ?>
            <?= $this->render('_select', ['question'=>$question]) ?>
            <?php break; ?>
        <?php case TestQuestionHelper::TYPE_CLOZE: ?>
            <?= $this->render('_nested', [ 'question' => $question]) ?>
            <?php break; ?>
        <?php default: ?>
    <?php endswitch; ?>
<?php endforeach; ?>
