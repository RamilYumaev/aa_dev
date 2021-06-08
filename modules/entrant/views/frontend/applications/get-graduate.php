<?php
/**
 * @var $department
 * @var $faculty
 * @var $currentFaculty;
 * @var $this View
 */
use yii\web\View;
?>
<?php if($department == \modules\entrant\helpers\AnketaHelper::HEAD_UNIVERSITY  && !$faculty): ?>
    <?= $this->render('graduate/_faculty',['department' => $department,  'currentFaculty' => $currentFaculty]) ?>
<?php else:?>
    <?= $this->render('graduate/_data',['department' => $department, 'currentFaculty' => $currentFaculty]) ?>
<?php endif; ?>






