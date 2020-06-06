<?php

use backend\widgets\adminlte\Box;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $anketa modules\entrant\models\Anketa */
/* @var $isUserSchool bool */

?>

<?php if ($anketa) : ?>
    <?php Box::begin(
        [
            "header" => "Данные анкеты",
            "type" => Box::TYPE_SUCCESS,
            "filled" => true,]) ?>

    <?php
    $columns = [
        ['label' => $anketa->getAttributeLabel('university_choice'),
            'value' => $anketa->universityChoice,],
        ['label' => $anketa->getAttributeLabel('citizenship_id'),
            'value' => $anketa->citizenship,],
        ['label' => $anketa->getAttributeLabel('current_edu_level'),
            'value' => $anketa->currentEduLevel,],
        ['label' => $anketa->getAttributeLabel('category_id'),
            'value' => $anketa->category,],
        'edu_finish_year'
    ];
    ?>
    <?php if ($anketa->isChina()): ?>
        <?php array_push($columns, 'province_of_china') ?>
    <?php endif; ?>
    <?php if ($anketa->isGovLineIncoming()): ?>
        <?php array_push($columns, 'personal_student_number') ?>
    <?php endif; ?>

    <?= DetailView::widget([
        'options' => ['class' => 'table table-bordered detail-view'],
        'model' => $anketa,
        'attributes' => $columns
    ]) ?>


<?php Box::end() ?>

<?php endif; ?>