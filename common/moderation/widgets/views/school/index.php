<?php
/* @var $this yii\web\View */

use modules\entrant\models\UserAis;
use yii\helpers\Html;

/* @var $item modules\entrant\models\DocumentEducation */
/* @var $model */
/* @var  $id integer */
?>
<div class="box box-danger">
    <div class="box-header">
        <h4>Документы об образовании</h4>
    </div>
    <div class="box-body" style="margin: 10px">
        <table class="table table-responsive">
            <tr>
                <th>Данные</th>
                <th>в АИС ВУЗ</th>
            </tr>
            <?php foreach ($model as $item) :
                $ais = UserAis::findOne(['user_id' => $item->user_id]); ?>
            <tr>
                <td><?= $item->getDocumentFull() ?></td>
                <td><?=  $ais ? Html::tag("span", "Загружен в АИС", ['class' => "label label-success"]) : Html::tag("span", "Не загружен в АИС", ['class' => "label label-danger"]); ?></td>
                <td><?= $ais ? Html::a('Обновить данные в АИС ВУЗ', ['update-export-data', 'did' => $item->id, 'user' => $item->user_id], ['class'=> 'btn btn-success', 'data' => [
                    'confirm' => 'Вы уверены, что хотите обновить данные в АИС ВУЗ?',
                    'method' => 'post',
                ]]) .Html::a('json', ['json', 'did' => $item->id, 'user' => $item->user_id], ['class'=> 'btn btn-danger pull-right']) : ''?>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>



