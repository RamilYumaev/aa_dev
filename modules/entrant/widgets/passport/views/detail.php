<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\PassportDataHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model modules\entrant\models\PassportData */
/* @var $isUserSchool bool */
?>

<div class="row">
    <div class="col-md-12 <?= BlockRedGreenHelper::colorBg($model ? true : false) ?>">
        <div class="p-30 green-border">
            <h4>Документ, удостоверяющий личность</h4>
            <?php if ($model) : ?>
                <?= Html::a('Редактировать', ['passport-data/update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
                <?= Html::a('Удалить', ['passport-data/delete', 'id' => $model->id], ['class' => 'btn btn-danger', 'data' => ['method' => 'post', 'confirm' => "Вы уверены что хотите удалить документ?"]]) ?>
                <?= DetailView::widget([
                    'options' => ['class' => 'table table-bordered detail-view'],
                    'model' => $model,
                    'attributes' => [
                        'nationalityName',
                        'typeName',
                        'series',
                        'number',
                        'date_of_birth:date',
                        'place_of_birth',
                        'date_of_issue:date',
                        'authority',
                        'division_code',
                    ]
                ]) ?>
            <?php else: ?>
            <?= Html::a('Добавить', ['passport-data/create'], ['class' => 'btn btn-success mb-10']) ?>
            <?php endif; ?>
        </div>
    </div>
</div>

