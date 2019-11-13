<?php


$this->title = 'Олимпиады и конкурсы МПГУ';
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('_list', [
    'dataProvider' => $dataProvider
]) ?>