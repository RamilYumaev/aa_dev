<?php

use yii\helpers\Html;
use entrant\assets\modal\ModalAsset;
/* @var $this yii\web\View */
/* @var $talons */
/* @var $talon modules\entrant\models\Talons */

ModalAsset::register($this);
$this->title = Yii::$app->controller->action->id === 'works'? "Ваши талоны": "Талоны";
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="box">
        <div class="box-header">
            <?= Html::a('Талоны',['index'],["class" => "btn btn-warning"]) ?>
            <?= Html::a('Ваши талоны',['works'],["class" => "btn btn-primary"]) ?>
        </div>
        <div class="box-body">
            <table class="table">
                <tr>
                    <th>#</th>
                    <th>Талон</th>
                    <th>ФИО Абитуриента</th>
                    <th>Телефон</th>
                    <th>Email</th>
                    <th>#</th>
                </tr>
                <?php $a=0; foreach ($talons as $talon): ?>
                <tr>
                    <td><?= ++$a?> </td>
                    <td><?= $talon->name ?></td>
                    <td><?= ($talon->anketaCi ? $talon->anketaCi->fio : '') . ($talon->entrant ? $talon->entrant->profiles->fio : '') ?></td>
                    <td><?= ($talon->anketaCi ? $talon->anketaCi->phone : '') . ($talon->entrant ? $talon->entrant->profiles->phone : '') ?></td>
                    <td><?= ($talon->anketaCi ? $talon->anketaCi->email : ''). ($talon->entrant ? $talon->entrant->email : '') ?></td>
                    <?php if($talon->isNew()): ?>
                    <td><?=  Html::a('Вызвать',['watting', 'id'=> $talon->id],['data-pjax' => 'w0'. $talon->id,
                            'data-toggle' => 'modal',
                            "class" => "btn btn-warning",
                            'data-target' => '#modal', 'data-modalTitle' => $talon->name]) ?></td>
                    <?php elseif ($talon->isWatting()): ?>
                        <td><?=  Html::a('Взять в работу',['work', 'id'=> $talon->id],["class" => "btn btn-info",
                                'data'=> [ 'confirm'=> "Вы уверены, что хотите взять в работу?"]]) ?>
                            <?=  Html::a('Отказаться',['danger', 'id'=> $talon->id],["class" => "btn btn-danger",
                                'data'=> [ 'confirm'=> "Вы уверены, что хотите отказаться?"]]) ?>
                        </td>
                    <?php elseif ($talon->isWork()): ?>
                        <td>
                        <?=  Html::a('Отказаться',['danger', 'id'=> $talon->id],["class" => "btn btn-danger",
                            'data'=> [ 'confirm'=> "Вы уверены, что хотите отказаться?"]]) ?>
                        <?=  Html::a('Завершить',['success', 'id'=> $talon->id],["class" => "btn btn-success",
                            'data'=> [ 'confirm'=> "Вы уверены, что хотите завершить?"]]) ?>
                        </td>
                    <?php endif;?>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
