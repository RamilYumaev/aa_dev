<?php

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\StatementHelper;
use modules\transfer\widgets\file\FileListWidget;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \modules\transfer\models\TransferMpgu */
?>
<?php if ($model && $data = $model->getJsonData()) :?>
    <?php Box::begin(
        [
            "header" => "Данные студента МПГУ",
            "type" => Box::TYPE_SUCCESS,
            "icon" => 'passport',
            "filled" => true,]) ?>
   <table class="table">
       <tr>
           <th>Факультет</th>
           <td><?= $data['faculty'] ?><td>
       </tr>
       <tr>
           <th>Образовательная программа</th>
           <td><?= $data['speciality'] ?><?= $data['specialization'] ? ', '.$data['specialization']:''?></td>
       </tr>
       <tr>
           <th>Форма обучения</th>
           <td><?= mb_strtolower($data['form']) ?></td>
       </tr>
       <tr>
           <th>Финансирование</th>
           <td><?= $data['finance'] ==1 ? "Бюджет" : "Договор" ?></td>
       </tr>
       <tr>
           <th>Курс</th>
           <td><?= $data['course'] ?></td>
       </tr>
       <tr>
           <th>Статус</th>
           <td><?= $model->current_status  == 7 ? "Отчислен" : "Активный" ?></td>
       </tr>
       <tr>
           <th>№ студенческой зачетки</th>
           <td><?= $model->number ?>, год выдачи - <?= $model->year ?></td>
       </tr>
       <tr>
           <th>Данные кадрового/ГИА приказа</th>
           <td><?= $model->data_order ?></td>
       </tr>
   </table>
    <?php Box::end() ?>
<?php endif; ?>

