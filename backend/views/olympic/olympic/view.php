<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $olympic \olympic\models\Olympic  */

$this->title = "Просмотр";
$this->params['breadcrumbs'][] = ['label' => 'Олимпиады/конкурсы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\modal\ModalAsset::register($this);
?>

    <div class="box box-default">
        <div class="box box-header">
        <p>
            <?= Html::a('Обновить', ['update', 'id' => $olympic->id], ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-modalTitle' =>'Редактировать', 'target' => '#modal', 'class' => 'btn btn-primary']) ?>
        </p>
        </div>
        <div class="box-body">
    <?= DetailView::widget([
        'model' => $olympic,
        'attributes' => [
            'name',
            ['attribute' => 'status',
                'value' => \olympic\helpers\OlympicHelper::statusName($olympic->status)
                ]
        ],
    ]) ?>
        </div>
    </div>
<?= \backend\widgets\olimpic\OlipicListInOLymipViewWidget::widget(['model'=> $olympic]) ?>

<?= \backend\widgets\testing\TestQuestionGroupWidget::widget(['model'=> $olympic]) ?>
