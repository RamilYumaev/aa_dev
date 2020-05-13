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
    <div class="col-md-12 <?= BlockRedGreenHelper::colorBg(PassportDataHelper::isExits(Yii::$app->user->identity->getId())) ?>">
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
                        'typeName', 'series',
                        'number', 'date_of_birth', 'place_of_birth', 'date_of_issue', 'authority',
                        'division_code',
                    ]
                ]) ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= \modules\entrant\widgets\passport\PassportDataWidget::widget(); ?>
