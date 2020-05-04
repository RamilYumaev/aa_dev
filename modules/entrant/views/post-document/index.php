<?php
/* @var $this yii\web\View */

\frontend\assets\modal\ModalAsset::register($this);
?>
<div class="container m-20">

<?= \modules\entrant\widgets\submitted\SubmittedDocumentGenerateStatementWidget::widget();?>

</div>
