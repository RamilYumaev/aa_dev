<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \modules\transfer\models\CurrentEducationInfo */
/* @var $isUserSchool bool */
?>
<div class="row">
    <div class="col-md-12 <?= BlockRedGreenHelper::colorBg($model) ?>">
        <div class="p-30 green-border">
            <h4>Куда осуществляется перевод/восстановление?</h4>
                <?php if ($model) : ?>
                    <?php
                    $columns = [
                            'year',
                            'faculty',
                        'speciality',
                        'specialization',
                        ['label' => $model->getAttributeLabel('form'),
                            'value' => $model->getFormEdu(),],
                        ['label' => $model->getAttributeLabel('finance'),
                            'value' => $model->getFinanceEdu(),],
                        ['label' => $model->getAttributeLabel('course'),
                            'value' => $model->dictCourse->classFullName,],
                    ];
                    ?>
                    <?= Html::a('Редактировать', ['/transfer/current-education-info'], ['class' => 'btn btn-warning']) ?>
                    <?= DetailView::widget([
                        'options' => ['class' => 'table table-bordered detail-view'],
                        'model' => $model,
                        'attributes' => $columns
                    ]) ?>
                <?php else: ?>
                    <?= Html::a('Добавить', ['/transfer/current-education-info'], ['class' => 'btn btn-success']) ?>
                <?php endif; ?>
        </div>
    </div>
</div>