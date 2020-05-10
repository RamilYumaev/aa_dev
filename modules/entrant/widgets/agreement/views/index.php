<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model modules\entrant\models\model */
/* @var $isUserSchool bool */
?>
<?php if ($model) : ?>
<div class="row">
    <div class="col-md-12 <?= BlockRedGreenHelper::colorBg($model ?? false) ?>">
        <h4>Договор о целовом обучении</h4>
        <?= Html::a('Редактировать', ['model/index'], ['class' => 'btn btn-primary']) ?>
                <?= DetailView::widget([
                    'options' => ['class' => 'table table-bordered detail-view'],
                    'model' => $model,
                    'attributes' =>  [
                        ['label' => $model->getAttributeLabel('organization_id'),
                            'value' => $model->organization,],
                        'number',
                        'date:date',
                    ]
                ]) ?>
        <?php endif; ?>
    </div>
</div>