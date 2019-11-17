

<?= \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => \yii\grid\SerialColumn::class],
        ['label' => "Олимпиада", 'value' => 'olympicOne.name'],
        ['label' => "Учебный год", 'value' => 'olympicOne.year'],
        ['class' => \yii\grid\ActionColumn::class,
            'controller' => '/user-olympic',
            'template' => '{delete}',
        ],
    ]
])
?>

