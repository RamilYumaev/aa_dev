
<?= \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => \yii\grid\SerialColumn::class],
        ['label' => "Олимпиада", 'value' => 'olympicOne.name'],
        ['label' => "Учебный год", 'value' => 'olympicOne.year'],
        ['value' => function($model) {
           $class= \common\auth\helpers\UserSchoolHelper::userClassId(\Yii::$app->user->identity->getId(),
               \common\helpers\EduYearHelper::eduYear());
           $test = \testing\helpers\TestHelper::testAndClassActiveOlympicList($model->olympicOne->id, $class);
          return  $test ? \yii\helpers\Html::a("Начать заочный тур", ['/test-attempt/start', 'test_id'=> $test],
              ['data' => ['confirm' => 'Вы действительно хотите начать заочный тур ?', 'method' => 'POST'], 'class' =>'btn btn-primary'] ): "";
        }, 'format'=>"raw" ],
        ['class' => \yii\grid\ActionColumn::class,
            'controller' => '/user-olympic',
            'template' => '{delete}',
            'buttons' =>[
                'delete' => function ($url, $model) {
                   return $model->olympicOne->year == \common\helpers\EduYearHelper::eduYear() ?
                       \yii\helpers\Html::a("Отменить запись", $url,  ['data' => ['confirm' => 'Вы действительно хотите отменить запись ?', 'method' => 'POST']]) : "";
                }
            ]
        ],
    ]
])
?>

