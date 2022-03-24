<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model modules\literature\forms\search\LiteratureOlympciSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="literature-olympic-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'birthday') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'series') ?>

    <?php // echo $form->field($model, 'number') ?>

    <?php // echo $form->field($model, 'date_issue') ?>

    <?php // echo $form->field($model, 'authority') ?>

    <?php // echo $form->field($model, 'region') ?>

    <?php // echo $form->field($model, 'zone') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'full_name') ?>

    <?php // echo $form->field($model, 'short_name') ?>

    <?php // echo $form->field($model, 'status_olympic') ?>

    <?php // echo $form->field($model, 'mark_olympic') ?>

    <?php // echo $form->field($model, 'grade_number') ?>

    <?php // echo $form->field($model, 'grade_letter') ?>

    <?php // echo $form->field($model, 'grade_performs') ?>

    <?php // echo $form->field($model, 'fio_teacher') ?>

    <?php // echo $form->field($model, 'place_work') ?>

    <?php // echo $form->field($model, 'post') ?>

    <?php // echo $form->field($model, 'academic_degree') ?>

    <?php // echo $form->field($model, 'size') ?>

    <?php // echo $form->field($model, 'is_allergy') ?>

    <?php // echo $form->field($model, 'note_allergy') ?>

    <?php // echo $form->field($model, 'is_voz') ?>

    <?php // echo $form->field($model, 'is_need_conditions') ?>

    <?php // echo $form->field($model, 'note_conditions') ?>

    <?php // echo $form->field($model, 'note_special') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'date_arrival') ?>

    <?php // echo $form->field($model, 'type_transport_arrival') ?>

    <?php // echo $form->field($model, 'place_arrival') ?>

    <?php // echo $form->field($model, 'number_arrival') ?>

    <?php // echo $form->field($model, 'date_departure') ?>

    <?php // echo $form->field($model, 'type_transport_departure') ?>

    <?php // echo $form->field($model, 'place_departure') ?>

    <?php // echo $form->field($model, 'number_departure') ?>

    <?php // echo $form->field($model, 'photo') ?>

    <?php // echo $form->field($model, 'agree_file') ?>

    <?php // echo $form->field($model, 'hash') ?>

    <div class="form-group">
        <?= Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Cброс', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
