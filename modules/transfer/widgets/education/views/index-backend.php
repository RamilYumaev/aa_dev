<?php

use backend\widgets\adminlte\Box;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \modules\transfer\models\CurrentEducation */
/* @var $isUserSchool bool */
?>
<?php if ($model) : ?>
    <?php Box::begin(
        [
            "header" => "Действующее образование",
            "type" => Box::TYPE_SUCCESS,
            "icon" => 'passport',
            "filled" => true,]) ?>
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
    ];
    ?>

    <?= DetailView::widget([
        'options' => ['class' => 'table table-bordered detail-view'],
        'model' => $model,
        'attributes' => $columns
    ]) ?>

    <?php Box::end() ?>
<?php endif; ?>

