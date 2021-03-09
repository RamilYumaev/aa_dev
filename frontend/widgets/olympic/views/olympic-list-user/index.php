<?php
\frontend\assets\modal\ModalAsset::register($this);
use yii\bootstrap\Modal;

$js = <<<SCRIPT
/* To initialize BS3 tooltips set this below */
$(function () { 
    $("[data-toggle='tooltip']").tooltip(); 
});
SCRIPT;
$this->registerJs($js);
?>
<?= \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => \yii\grid\SerialColumn::class],
        ['label' => "Олимпиада", 'value' => 'olympicOne.name'],
        ['label' => "Учебный год", 'value' => 'olympicOne.year'],
        ['class' => \frontend\widgets\olympic\gird\user\PersonalUserOlympicColumn::class,],
        ['class' => \yii\grid\ActionColumn::class,
            'controller' => '/user-olympic',
            'template' => '{delete}',
            'buttons' =>[
                'delete' => function ($url, $model) {
                    $class = \common\auth\helpers\UserSchoolHelper::userClassId(\Yii::$app->user->identity->getId(), \common\helpers\EduYearHelper::eduYear());
                    $test = \testing\helpers\TestHelper::testAndClassActiveOlympicList($model->olympicOne->id, $class);
                    return $model->olympicOne->year == \common\helpers\EduYearHelper::eduYear() &&
                       $model->olympicOne->isOnRegisterOlympic  && !\testing\helpers\TestAttemptHelper::isAttempt($test, \Yii::$app->user->identity->getId()) ?
                       \yii\helpers\Html::a("Отменить запись", $url,  ['data' => ['confirm' => 'Вы действительно хотите отменить запись ?', 'method' => 'POST']]) : "";
                }
            ]
        ],
    ]
])
?>

<?php Modal::begin(['id'=>'modal', 'size'=> Modal::SIZE_LARGE, 'header' => "<h4 id='header-h4'></h4>", 'clientOptions' => ['backdrop' => false]]);
echo "<div id='modalContent'></div>";
Modal::end()?>

