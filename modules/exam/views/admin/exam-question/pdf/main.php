<?php
/* @var $questions \yii\db\ActiveRecord */

/* @var  $question modules\exam\models\ExamQuestion */
use modules\exam\helpers\ExamQuestionHelper;

?>
<?php foreach ($questions as  $question) : ?>
    <?php switch ($question->type_id):
         case ExamQuestionHelper::TYPE_SELECT_ONE: ?>
            <?= $this->render('_one', ['question' => $question]) ?>
            <?php break; ?>
        <?php case ExamQuestionHelper::TYPE_MATCHING: ?>
            <?= $this->render('_matching', ['question'=>$question]) ?>
            <?php break; ?>
        <?php default: ?>
        <?= $this->render('nested', [ 'question' => $question]) ?>
    <?php endswitch; ?>
<?php endforeach; ?>
