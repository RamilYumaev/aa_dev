<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $agreement modules\entrant\models\Agreement */
/* @var $isUserSchool bool */
?>
<?php if ($agreement) : ?>
<div class="row">
    <div class="col-md-12 <?= BlockRedGreenHelper::colorBg($agreement ?? false) ?>">
        <h4>Договор о целовом обучении</h4>
        <?= Html::a('Редактировать', ['agreement/index'], ['class' => 'btn btn-primary']) ?>
                <?= DetailView::widget([
                    'options' => ['class' => 'table table-bordered detail-view'],
                    'model' => $agreement,
                    'attributes' =>  [
                        ['label' => $agreement->getAttributeLabel('organization_id'),
                            'value' => $agreement->organization,],
                        'number',
                        'date:date',
                    ]
                ]) ?>
        <?php endif; ?>
    </div>
</div>