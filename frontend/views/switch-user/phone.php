<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $phone \olympic\models\auth\Profiles */
/* @var $model frontend\search\Profile*/
/* @var $type  string */
?>
<div class="p-30 green-border">
    <h4>Данные по телефону: <?= $model->phone ?> </h4>
    <?php
    if ($phone) :?>
    <?= Html::a('Перейти в ЛК',['by-user-id', 'id'=> $phone->user_id]) ?>
        <?= DetailView::widget([
        'options' => ['class' => 'table table-bordered detail-view'],
        'model' => $phone,
        'attributes' => [
            'user.email',
            'last_name', 'first_name', 'patronymic' , 'phone',
            'user:boolean'
        ]
    ]) ?>
    <?php else: ?>
        <p>Ничего не найдено</p>
    <?php endif; ?>
</div>
