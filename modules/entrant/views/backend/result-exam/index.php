<?php
use yii\grid\ActionColumn;
use backend\widgets\adminlte\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel modules\entrant\searches\StatementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $status integer */
$this->title = "Конкурсные группы. Результаты экзаменов";

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <div class="box">
        <div class="box-header"><?= Yii::$app->session->setFlash('warning',
                'Чтобы должность и ФИО были  указаны в "Лицо, сформировашее документ", необходимо '.
                    \yii\helpers\Html::a('изменить/добавить должность','/profile/entrant-job')); ?></div>
        <div class="box-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                        'fullNameB',
                    ['class' => ActionColumn::class, 'controller' => 'result-exam', 'template' => '{view}']
                ],
            ]); ?>
        </div>
    </div>
</div>

