<?php
/* @var $this yii\web\View */

\frontend\assets\modal\ModalAsset::register($this);

$this->title = 'Загрузка сканированных копий документов';

$this->params['breadcrumbs'][] = ['label' => 'Определение условий подачи документов', 'url' => ['/abiturient/anketa/step1']];
$this->params['breadcrumbs'][] = ['label' => 'Выбор уровня образования', 'url' => ['/abiturient/anketa/step2']];
$this->params['breadcrumbs'][] = ['label' => 'Заполнение персональной карточки поступающего', 'url' => ['/abiturient/default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container m-20">

<?= \modules\entrant\widgets\submitted\SubmittedDocumentGenerateStatementWidget::widget();?>

</div>
