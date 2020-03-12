<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $document_education modules\entrant\models\DocumentEducation */
/* @var $isUserSchool bool */
?>

<div class="row">
    <div class="col-md-12">
        <h4>Документ об образовании</h4>
        <?php if($isUserSchool) :?>
            <?php if($document_education) :?>
                <?= Html::a('Редактировать', ['document-education/update','id'=>$document_education->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Удалить', ['document-education/delete','id'=>$document_education->id], ['class' => 'btn btn-danger','data'=> ['method'=> 'post', 'confirm'=> "Вы уверены что хотите удалить документ об образовании?"]]) ?>
                <?= DetailView::widget([
                    'model' => $document_education,
                    'attributes' => [
                        ['label'=> $document_education->getAttributeLabel('school_id'),
                        'value' =>$document_education->schoolName,],
                        ['label'=>$document_education->getAttributeLabel('type'),
                            'value' =>$document_education->typeName,],
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