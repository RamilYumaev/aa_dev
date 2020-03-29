<?php
$this->title = 'ЕГЭ';
$this->params['breadcrumbs'][] = ["label"=> "Шаг2. Выбор уровня образования", "url"=> "/abiturient/anketa/step2/"];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container m-20">

<?= \modules\entrant\widgets\cse\CseSubjectResultWidget::widget();?>

</div>