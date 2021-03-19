<?php
/* @var $this yii\web\View */

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $task modules\management\models\Task */
/* @var $comment modules\management\models\CommentTask */

?>
<?php foreach ($task->getCommentTasks()->orderBy(['created_at'=> SORT_DESC])->all() as $comment): ?>
    <div class="box box-warning">
        <div class="box-header">
            <h4><?= $comment->profile->fio." ". $comment->created_at ?></h4>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-10"><?= $comment->text?></div>
                <div class="col-md-2">
                    <?php if(!$task->isStatusesAccepted()) :?>
                    <?=  $comment->created_by == Yii::$app->user->identity->getId() ?
                        Html::a('<span class="fa fa-pencil-square-o"></span>',['comment-task/update',
                        'id' =>$comment->id,  'task_id' =>$comment->task_id], ['data-pjax' => 'w7', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => 'Редактировать комментарий']): "" ?>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


