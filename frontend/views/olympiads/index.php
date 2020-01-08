<?php


$this->title = 'Олимпиады и конкурсы МПГУ';
$this->params['breadcrumbs'][] = $this->title;

?>
    <div class="container">
        <h1><?= $this->title ?></h1>
<?= $this->render('_list', [
    'dataProvider' => $dataProvider
]) ?>

    </div>
