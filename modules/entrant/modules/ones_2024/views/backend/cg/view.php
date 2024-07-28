<?php
use entrant\assets\modal\ModalAsset;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \modules\entrant\modules\ones_2024\model\CgSS */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \modules\entrant\modules\ones_2024\forms\search\EntrantAppSearch */
ModalAsset::register($this);
$this->title = "Конкурсная группа. Просмотр. " .$model->name;
$this->params['breadcrumbs'][] = ['label' => '"Конкурсные группы"', 'url' => ['cg/index']];

$this->params['breadcrumbs'][] = $this->title;

?>
    <div class="box table-responsive">
        <div class="box-header">
            <?= Html::a(
                '<span class="glyphicon glyphicon-pencil"></span>',
                ['update', 'id'=>$model->id],
                ["class" => "btn btn-danger"]
            );?>
        </div>
        <div class="box-body ">
            <?= \yii\widgets\DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                    'education_level',
                    'education_form',
                    'code_spec',
                    'speciality',
                    'profile',
                    'type',
                    'kcp',
                    'status',
                    'datetime_url:datetime'
                ],
            ]) ?>
        </div>
    </div>
<div>
    <div class="box table-responsive">
        <div class="box-header">
            <h5>Конкрусные списки epk24.mpgu.su</h5>
            <?=  $model->url ? Html::a(
                'Получить конкурсные списки из epk24.mpgu.su',
                ['get-list-epk', 'id' => $model->id],
                ["class" => "btn btn-danger"]): '' ?>

            <?= Html::a(
                'Скачать список epk + CC',
                ['table-file', 'id'=> $model->id],
                ["class" => "btn btn-success"]
            );?>

            <?php
//            Html::a(
//                'Ручные изменения',
//                ['update-fok', 'id'=> $model->id],
//                ["class" => "btn btn-danger",
//                    'data-pjax' => 'w9', 'data-toggle' => 'modal', 'data-target' => '#modal',
//                    'data-modalTitle' => 'Обновление']
//            );
            ?>

            <?= $model->file ? Html::a(
                'Скачать ручные изменения',
                ['get', 'id'=> $model->id],
                ["class" => "btn btn-success"]
            ) : '' ?>

<!--            --><?php //= Html::a(
//                'Итоговый список',
//                ['table-file', 'id'=> $model->id, 'fok' => 1],
//                ["class" => "btn btn-success"]
//            );?>

        </div>
        <div class="box-body">
            <?=\yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => ['number','fio', 'phone','snils_number','exam_1','exam_2','exam_3','sum_exams',
                'sum_individual',
                'sum_ball',
                'name_exams',
                'priority',
                'original','right','is_pay','document','document_target']
            ]);?>
        </div>
    </div>
</div>
