<?php
/* @var $this yii\web\View */

/* @var $userCg array */
?>
<div class="row ">
    <div class="col-xs-12">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <th>#</th>
                <th>Направление подготовки</th>
                <th>Образовательная программма</th>
                <th>Форма обучения</th>
                <th>Основание приема</th>
                <th>Федеральный бюджет</th>
                <th>Платное обучение</th>
            </tr>
            <?php foreach ($userCg as $key => $value) :?>
                <tr>
                    <td><?=++$key?></td>
                    <td><?= $value["speciality"] ?></td>
                    <td><?= $value['specialization']?></td>
                    <td><?= $value['form']?></td>
                    <td><?= $value['special_right'] ?></td>
                    <td><h4><?= $value['budget'] ?? "" ?></h4></td>
                    <td><h4><?= $value['contract'] ?? "" ?></h4></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
