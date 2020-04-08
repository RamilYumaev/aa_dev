<?php
use yii\helpers\Html;
use modules\entrant\helpers\PostDocumentHelper;
/* @var $this yii\web\View */
/* @var $submitted modules\entrant\models\SubmittedDocuments */
?>
<div class="row">
    <div class="col-md-12">
        <div class="mt-20">
            <?php if($submitted): ?>
                <h4>Ваш способ подачи документов - <?= PostDocumentHelper::link($submitted->type, ['post-document/index']) ?></h4>
            <?php endif; ?>
            <h4>Способы подачи документов</h4>
            <?php foreach (PostDocumentHelper::submittedList() as $key => $value) :
                if($submitted && $submitted->type == $key) {continue;} ?>
            <?= PostDocumentHelper::link($key)?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
