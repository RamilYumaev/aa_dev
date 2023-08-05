<?php
$this->title = "Админ";
use yii\helpers\Html; ?>
<div>
    <div class="box">
        <div class="box-header">
            <?= Html::a('Провести конкурс', ['list-handle'], ['class'=>'btn btn-danger', 'data-confirm'=> "Вы уверенны, что хотичте это сделать?"]) ?>
            <?= Html::a('Найти полупроходные баллы', ['semi-handle'], ['class'=>'btn btn-warning', 'data-confirm'=> "Вы уверенны, что хотичте это сделать?"]) ?>
        </div>
        <div class="box-header">
            <?= Html::a('Конкурсные группы', ['default/index'], ['class'=>'btn btn-info']) ?>
            <?= Html::a('Конкурсные списки', ['competitive-list/index'], ['class'=>'btn btn-info']) ?>
            <?= Html::a('Приказы', ['order-transfer/index'], ['class'=>'btn btn-info']) ?>
        </div>
    </div>
    </div>
</div>
