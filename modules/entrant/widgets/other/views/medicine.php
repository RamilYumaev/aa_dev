<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $other modules\entrant\models\OtherDocument */
/* @var $type  string */
?>
<div class="row">
    <div class="col-md-12
<?= BlockRedGreenHelper::colorBg($other ?? false) ?>">
        <div class="p-30 green-border">
            <h4><?= "Заключение об
                    отсутсвии противопоказаний для обучения (медицинская справка 086у; дествующая медицинская книжка)" ?></h4>
            <?php
            if ($other) :
                $column = [
                    ['label' => $other->getAttributeLabel('type'),
                        'value' => $other->typeName,],
                    'series',
                    'number',
                    'authority',
                    'date:date',
                ];
            ?>
                <?= Html::a('Редактировать', ['other-document/medicine'],
                ['class' => 'btn btn-success']) ?>
                <?= DetailView::widget([
                'options' => ['class' => 'table table-bordered detail-view'],
                'model' => $other,
                'attributes' => $column
            ]) ?>
            <?php else: ?>
                <?= Html::a('Добавить', ['other-document/medicine'],
                    ['class' => 'btn btn-success']) ?>
            <?php endif; ?>
        </div>
    </div>
</div>
