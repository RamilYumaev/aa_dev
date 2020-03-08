<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $document_education modules\entrant\models\DocumentEducation */
/* @var $isUserSchool bool */
?>

<div class="row">
    <div class="col-md-12">
        <h4>Документ об образовнии</h4>
        <?php if($isUserSchool) :?>
            <?php if($document_education) :?>
                <?= Html::a('Редактировать', ['document-education/update','id'=>$document_education->id], ['class' => 'btn btn-primary']) ?>
                <?= DetailView::widget([
                    'model' => $document_education,
                    'attributes' => [
                        'school_id',
                        'type',
                        'series',
                        'number',
                        'date:date',
                        'year'
                    ],
                ]) ?>
            <?php else:?>
                <?= Html::a('Добавить документ', ['document-education/create'], ['class' => 'btn btn-success']) ?>
            <?php endif;?>
        <?php else:?>
             <p>Чтобь добавить документ об образовании необходимо акутализировать раздел <?= Html::a('"Учебные организации"', '@frontendInfo/schools', ['class' => 'btn btn-warning']) ?></p>
        <?php endif;?>
    </div>
</div>