<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $question \testing\models\TestQuestion */

$this->title = $question->title;
$this->params['breadcrumbs'][] = ['label' => 'Вопросы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>


<div class="question-view">
    <p>
        <?= Html::a('Обновить', ['update', 'id' => $question->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $question->id], [
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
                'model' => $question,
                'attributes' => [
                    'id',
                    'text:raw',
                ],
            ]) ?>
        </div>
    </div>
    <div>
        <?php var_dump(\yii\helpers\Json::decode($question->options)); ?>
    </div>
</div>
