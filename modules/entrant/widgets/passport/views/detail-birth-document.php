<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\PassportDataHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use \modules\entrant\helpers\PostDocumentHelper;

/* @var $this yii\web\View */
/* @var $model modules\entrant\models\PassportData */
/* @var $userId integer */
?>

<div class="row">
    <div class="col-md-12 <?= BlockRedGreenHelper::colorBg(PostDocumentHelper::exemptionNoParent($userId)) ?>">
        <div class="p-30 green-border">
            <h4>Свидетельство о рождении</h4>
            <?php if ($model) : ?>
                <?= Html::a('Редактировать', ['passport-data/update-birth-document', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
                <?= Html::a('Удалить', ['passport-data/delete', 'id' => $model->id], ['class' => 'btn btn-danger', 'data' => ['method' => 'post', 'confirm' => "Вы уверены что хотите удалить документ?"]]) ?>
                <?= DetailView::widget([
                    'options' => ['class' => 'table table-bordered detail-view'],
                    'model' => $model,
                    'attributes' => [
                        ['value'=> $model->nationalityName, 'label'=> 'Страна выдачи'],
                        'typeName',
                        'series',
                        'number',
                        'date_of_issue:date',
                        'authority',
                    ]
                ]) ?>
            <?php else: ?>
            <?= Html::a('Добавить', ['passport-data/create-birth-document'], ['class' => 'btn btn-success mb-10']) ?>
            <?php endif; ?>
        </div>
    </div>
</div>

