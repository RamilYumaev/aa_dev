<?php
$this->title= "Регистрация на участие";
$this->params['breadcrumbs'][] = ['label' => 'Всероссийская олимпиада школьников по литературе', 'url' => 'default/index'];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('form/_form', [
    'model' => $model
]) ?>
