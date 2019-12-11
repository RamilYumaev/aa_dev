<?php
\frontend\assets\modal\ModalAsset::register($this);
use yii\bootstrap\Modal;
?>
<?= \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => \yii\grid\SerialColumn::class],
        ['label' => "Олимпиада", 'value' => 'olympicOne.name'],
        ['label' => "Учебный год", 'value' => 'olympicOne.year'],
        ['value' => function($model) {
           $class= \common\auth\helpers\UserSchoolHelper::userClassId(\Yii::$app->user->identity->getId(), \common\helpers\EduYearHelper::eduYear());
           $test = \testing\helpers\TestHelper::testAndClassActiveOlympicList($model->olympicOne->id, $class);
          return  $test ? \yii\helpers\Html::a('Начать заочный тур', ['/test/start','id' => $test],
              ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle'
              =>'Заочный тур', 'class'=>'btn btn-primary']): "";
        }, 'format'=>"raw" ],
        ['class' => \yii\grid\ActionColumn::class,
            'controller' => '/user-olympic',
            'template' => '{delete}',
            'buttons' =>[
                'delete' => function ($url, $model) {
                   return $model->olympicOne->year == \common\helpers\EduYearHelper::eduYear() &&
                       $model->olympicOne->isOnRegisterOlympic ?
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

