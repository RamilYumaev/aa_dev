<?php
/* @var $this yii\web\View */
/* @var $id int */
/* @var $searchModel \common\user\search\SchoolSearch */
use yii\helpers\Html;
use yii\widgets\ListView; ?>

<div class="box box-primary">
    <div class="box-header"><h4>Поиск школ</h4></div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">
            <?php echo $this->render('_form_search', ['model' => $searchModel]); ?>
            </div>
            <div class="col-md-8">
                <?= ListView::widget([
                        'emptyText' => 'Ничего не найдено <br />'.Html::a('Отклонить с заменой на новую запись', ['reject-change', 'id' => $id], ['class'=> 'btn btn-danger', 'data' => [
                                'confirm' => 'Вы уверены, что хотите сделать?',
                                'method' => 'post',
                            ]]),
                    'dataProvider' => $dataProvider,
                    'itemView' => function (\dictionary\models\DictSchools $model) use($id) {
                        return Html::beginTag('div',['class'=>"row"]).Html::beginTag('div',['class'=>"col-md-11"]).
                            Html::tag('h4', $model->name. Html::tag('small', ' '.$model->countryRegion))
                            .Html::beginTag('span', ['class' => 'pull-right']).
                            Html::a('Отклонить с заменой на выбраную запись', ['reject-change', 'id' => $id, 'school' => $model->id], ['class'=> 'btn btn-warning', 'data' => [
                                'confirm' => 'Вы уверены, что хотите сделать?',
                                'method' => 'post',
                            ]])
                            .Html::endTag('span') .Html::endTag('div') .Html::endTag('div').Html::tag('hr');
                    },
                ]) ?>
            </div>
        </div>
    </div>
</div>
