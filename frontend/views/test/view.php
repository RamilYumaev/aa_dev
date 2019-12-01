<?php
use yii\helpers\Html;
use testing\helpers\TestQuestionHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $pages integer */
/* @var $models yii\data\ActiveDataProvider */
/* @var $quent testing\models\TestAndQuestions */
/* @var $test \testing\models\Test */


for ($i=1; $i <= $pages; ++$i) { ?>
    <?= Html::a('<span>'.$i.'</span>', ['view','id' => $test->id, 'page' => $i],['class' =>
        $i == Yii::$app->request->get('page') ? "btn btn-primary" :  "btn btn-success",  'data-toggle'=>'tooltip' ]); ?>
<?php  }

$form = ActiveForm::begin(['id' => 'edu']);?>
<?php foreach ($models as $quent): ?>
    <?php switch (TestQuestionHelper::questionType($quent->question_id)):
        case TestQuestionHelper::TYPE_SELECT: ?>
            <?= $this->render('@frontend/views/test/type/select', ['quent' => $quent]) ?>
            <?php break; ?>
        <?php case TestQuestionHelper::TYPE_SELECT_ONE: ?>
            <?= $this->render('@frontend/views/test/type/select-one', ['quent' => $quent]) ?>
            <?php break; ?>
        <?php case TestQuestionHelper::TYPE_MATCHING: ?>
            <?= $this->render('@frontend/views/test/type/matching', ['quent' => $quent]) ?>
            <?php break; ?>
        <?php case TestQuestionHelper::TYPE_ANSWER_DETAILED: ?>
            <?= $this->render('@frontend/views/test/type/detailed', ['quent' => $quent]) ?>
            <?php break; ?>
        <?php case TestQuestionHelper::TYPE_ANSWER_SHORT: ?>
            <?= $this->render('@frontend/views/test/type/short', ['quent' => $quent]) ?>
            <?php break; ?>
        <?php case TestQuestionHelper::TYPE_FILE: ?>
            <?= $this->render('@frontend/views/test/type/file', ['quent' => $quent]) ?>
            <?php break; ?>
        <?php default: ?>
            <?= $this->render('@frontend/views/test/type/cloze', ['quent' => $quent]) ?>
        <?php endswitch; ?>
<?php  endforeach; ?>
<?= Html::submitButton("да") ?>
<?php ActiveForm::end();?>