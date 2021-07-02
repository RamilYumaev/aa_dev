<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model modules\entrant\models\Agreement */
?>
<?php if ($model) : ?>
<div class="row">
    <div class="col-md-12 <?= BlockRedGreenHelper::colorBg($model && $model->date ?? false) ?>">
        <div class="p-30 green-border">
            <h4>Договор о целовом обучении</h4>
            <?= Html::a('Редактировать', ['agreement/index'], ['class' => 'btn btn-primary']) ?>
            <?= DetailView::widget([
                'options' => ['class' => 'table table-bordered detail-view'],
                'model' => $model,
                'attributes' => [
                        ['label'=> 'Заказчик', 'value'=> $model->organization ? $model->fullOrganization : ''],
                    ['label'=> 'Работодатель', 'value'=> $model->organizationWork ? $model->fullOrganizationWork : ''],
                    'number',
                    'date:date',
                ]
            ]) ?>
            <?php endif; ?>
        </div>
    </div>
</div>