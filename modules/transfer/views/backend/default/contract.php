<?php
$this->title = "Договоры ПиВ";
$this->params['breadcrumbs'][] = ['label' => 'Перевод и восстановление', 'url' => ['default/index']];
?>
<?= $this->render('_contract',['jobEntrant' => $jobEntrant])?>
<?= $this->render('_receipt',['jobEntrant' => $jobEntrant])?>