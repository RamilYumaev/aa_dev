<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \modules\transfer\models\CurrentEducation */
/* @var $isUserSchool bool */

?>
<div class="row">
    <div class="col-md-12 <?= BlockRedGreenHelper::colorBg($model) ?>">
        <div class="p-30 green-border">
        <h4>Действующее образование</h4>
        <?php if ($isUserSchool) : ?>
            <?php if ($model) : ?>
                <?php
                $columns = [
                    ['label' => $model->getAttributeLabel('school_id'),
                        'value' => $model->school->name,],
                    'school_name',
                    'speciality',
                    'specialization',
                    ['label' => $model->getAttributeLabel('form'),
                        'value' => $model->getFormEdu(),],
                    ['label' => $model->getAttributeLabel('edu_count'),
                        'value' => $model->getEduName(),],
                    ['label' => $model->getAttributeLabel('finance'),
                        'value' => $model->getFinanceEdu(),],
                    ['label' => $model->getAttributeLabel('course'),
                        'value' => $model->dictCourse->classFullName,],
                    //['label' => $document_education->getAttributeLabel('original'),
                    // 'value' => $document_education->getOriginal(),],
                ];
                ?>
                <?= Html::a('Редактировать', ['/transfer/current-education'], ['class' => 'btn btn-warning']) ?>
                <?= DetailView::widget([
                    'options' => ['class' => 'table table-bordered detail-view'],
                    'model' => $model,
                    'attributes' => $columns
                ]) ?>
            <?php else: ?>
                <?= Html::a('Добавить', ['/transfer/current-education'], ['class' => 'btn btn-success']) ?>
            <?php endif; ?>
        <?php else: ?>
            <p> Необходимо актуализировать
                раздел <?= Html::a('"Учебные организации"',
                    ['/schools/create', 'redirect' => 'transfer-registration'], ['class' => 'btn btn-warning']) ?></p>
        <?php endif; ?>
        </div>
    </div>
</div>