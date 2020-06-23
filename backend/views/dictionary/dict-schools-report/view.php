<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $school dictionary\models\DictSchoolsReport */
/* @var $isAdd boolean */

$title = $isAdd ? " Поиск и добавление": " Просмотр";
$this->title = $school->school->name. $title;
$this->params['breadcrumbs'][] = ['label' => 'Учебные организации. Для отчетов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="school-view">
        <div class="box">
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $school,
                    'attributes' => [
                        ['label' => 'Наименование',
                            'value' => $school->school->name,
                        ],
                        ['label' => 'Email',
                            'value' => $school->school->email
                        ],
                        ['label' => 'Страна',
                            'value' => $school->school->country->name,
                        ],
                        ['label' => 'Регион',
                            'value' =>  $school->school->region->name ,
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
 <?php if(!$isAdd) : ?>
  <?= Html::a("Поиск и добавить", ['add', 'id'=> $school->id],['class'=>"btn btn-success"]) ?>
 <?php else: ?>
    <?= Html::a("Вернуться", ['view', 'id'=> $school->id],['class'=>"btn btn-primary"]) ?>
 <?php endif; ?>
<?= \backend\widgets\dictionary\DictSchoolsWidget::widget(['model' =>$school, 'isAdd' => $isAdd]) ?>