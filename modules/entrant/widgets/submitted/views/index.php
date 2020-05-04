<?php
use modules\entrant\helpers\PostDocumentHelper;
/* @var $this yii\web\View */
/* @var $submitted modules\entrant\models\SubmittedDocuments */
?>
<div class="row">
    <div class="col-md-12">
        <div class="mt-20">
            <?php foreach (PostDocumentHelper::submittedList() as $key => $value) :?>
            <?= PostDocumentHelper::link($key)?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
