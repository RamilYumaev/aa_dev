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
                <h4>Ваш способ подачи документов - <?= $submitted->typeName ?></h4>
            <?php endif; ?>
            <h4>Способы подачи документов</h4>
            <?php foreach (PostDocumentHelper::submittedList() as $key=> $value) :?>
            <?= Html::a($value, PostDocumentHelper::value(PostDocumentHelper::submittedListUrl(), $key),
                        ['class'=> PostDocumentHelper::value(PostDocumentHelper::submittedLisClass(), $key),
                            'data'=> ['method' => 'post']])?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
