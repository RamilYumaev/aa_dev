<?php

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $document_education modules\entrant\models\DocumentEducation */
/* @var $isUserSchool bool */
?>
<?php if ($document_education) : ?>
    <?php Box::begin(
        [
            "header" => "Документ об образовании",
            "type" => Box::TYPE_SUCCESS,
            "icon" => 'passport',
            "filled" => true,]) ?>

    <?php
    $columns = [
        ['label' => $document_education->getAttributeLabel('school_id'),
            'value' => $document_education->schoolName,],
        ['label' => $document_education->getAttributeLabel('type'),
            'value' => $document_education->typeName,],
        'series',
        'number',
        'date:date',
        'year',
        //['label' => $document_education->getAttributeLabel('original'),
        // 'value' => $document_education->getOriginal(),],
    ];
    ?>
    <?php if ($document_education->surname && $document_education->name): ?>
        <?php array_push($columns, 'surname', 'name', 'patronymic') ?>
    <?php endif; ?>
    <?= DetailView::widget([
        'options' => ['class' => 'table table-bordered detail-view'],
        'model' => $document_education,
        'attributes' => $columns
    ]) ?>

<?php endif; ?>
<?php Box::end() ?>
