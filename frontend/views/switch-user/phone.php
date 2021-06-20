<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $phone \olympic\models\auth\Profiles */
/* @var $model frontend\search\Profile*/
/* @var $type  string */
?>
<div class="row">
    <div class="col-md-6">
        <div class="p-30 green-border">
            <h4>Данные по email: <?php $model->phone ?> </h4>
            <?php
            if ($phone) :
            ?>
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
    </div>
</div>
