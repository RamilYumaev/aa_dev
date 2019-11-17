

<?= \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => \yii\grid\SerialColumn::class],
        ['label' => "Олимпиада", 'value' => 'olympicOne.name'],
        ['label' => "Учебный год", 'value' => 'olympicOne.year'],
        ['class' => \yii\grid\ActionColumn::class,
            'controller' => '/user-olympic',
            'template' => '{delete}',
            'buttons' =>[
                'delete' => function ($url, $model) {
                   return $model->olympicOne->year == \common\helpers\EduYearHelper::eduYear() ?
                       \yii\helpers\Html::a("Снять запись", $url,  ['data' => ['confirm' => 'Вы действительно хотите отменить запись ?', 'method' => 'POST']]) : "";
                }
            ]
        ],
    ]
])
?>

