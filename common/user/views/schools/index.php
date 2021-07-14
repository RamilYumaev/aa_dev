<?php
/* @var $this yii\web\View */
/* @var $role int */
/* @var $searchModel \common\user\search\SchoolSearch */
\frontend\assets\modal\ModalAsset::register($this);
use yii\helpers\Html;
use yii\widgets\ListView; ?>
<?= \common\user\widgets\SchoolsWidget::widget(['role'=> $role])?>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-30">
            <h1>Поиск</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?php echo $this->render('_form_search', ['model' => $searchModel]); ?>
        </div>
        <div class="col-md-8">
            <?= ListView::widget([
                    'emptyText' => 'Ничего не найдено <br />'.  Html::a('Добавить новую', ['create'],  ['data-pjax' => 'w0'.$model->id, 'data-toggle' => 'modal',
                    'data-target' => '#modal', 'class'=>'btn btn-success pull-right', 'data-modalTitle' => 'Добавить новую учебную организацию']) ,
                'dataProvider' => $dataProvider,
                'itemView' => function (\dictionary\models\DictSchools $model) {
                    return Html::beginTag('div',['class'=>"row"]).Html::beginTag('div',['class'=>"col-md-8"]).
                        Html::tag('h4', $model->name. Html::tag('small', ' '.$model->countryRegion))
                         .Html::endTag('div').Html::beginTag('div',['class'=>"col-md-4"]).
                        Html::a('Изменить',
                            ['update', 'id' => $model->id], ['data-pjax' => 'w75'.$model->id, 'data-toggle' => 'modal',
                                'data-target' => '#modal', 'class'=>'btn btn-info btn-xs pull-right', 'data-modalTitle' => 'Редактирование']).
                        Html::a('Выбрать',
                        ['select', 'id' => $model->id], ['data-pjax' => 'w0'.$model->id, 'data-toggle' => 'modal',
                            'data-target' => '#modal', 'class'=>'btn btn-primary btn-xs pull-right', 'data-modalTitle' =>'Ваш выбор: '. $model->name." ".$model->countryRegion]).
                            Html::a('Заменить',
                                ['change', 'id' => $model->id], ['data-pjax' => 'w5'.$model->id, 'data-toggle' => 'modal',
                                    'data-target' => '#modal', 'class'=>'btn btn-warning btn-xs pull-right', 'data-modalTitle' =>'Замена: '. $model->name." ".$model->countryRegion])
                        .Html::endTag('div') .Html::endTag('div').Html::tag('hr');
                },
            ]) ?>
        </div>
    </div>
</div>
