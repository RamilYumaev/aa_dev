<?php
/* @var $this yii\web\View */

use yii\helpers\ArrayHelper;

/* @var $task modules\management\models\Task */
/* @var $comment modules\management\models\CommentTask */

?>
<?php foreach ($task->getCommentTasks()->orderBy(['created_at'=> SORT_DESC])->all() as $comment): ?>
    <div class="box box-warning">
        <div class="box-header">
            <h4><?= $comment->profile->fio." ". $comment->created_at ?></h4>
        </div>
        <div class="box-body"> <?= $comment->text?>
        </div>
    </div>
<?php endforeach; ?>


