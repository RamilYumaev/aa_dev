<?php

use dictionary\helpers\DictCompetitiveGroupHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $dod dod\models\Dod */

$this->title = $dod->name;
$this->params['breadcrumbs'][] = ['label' => 'Все дни открытых дверей', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faculty-view">
    <p>
        <?= Html::a('Обновить', ['update', 'id' => $dod->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $dod->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $dod,
                'attributes' => [
                    'name:ntext',
                    ['attribute' => 'type',
                        'value' => \dod\helpers\DodHelper::statusName($dod->type) ],
                    ['attribute' => 'edu_level',
                        'value' => DictCompetitiveGroupHelper::eduLevelName($dod->edu_level) ],
                    ['attribute' =>'faculty_id',
                     'value' => \dictionary\helpers\DictFacultyHelper::facultyName($dod->faculty_id) ],
                    'aud_number',
                    'address:ntext',
                    'photo_report',
                ],
            ]) ?>
        </div>
    </div>

    <?= \backend\widgets\dod\DateDodWidget::widget(['dod_id'=> $dod->id]) ?>
</div>
