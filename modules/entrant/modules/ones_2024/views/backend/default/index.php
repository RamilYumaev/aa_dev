<?php
/* @var $this yii\web\View */

use yii\data\ArrayDataProvider;

$this->title = 'Тест';
$this->params['breadcrumbs'][] = $this->title;
$data = [
];

$provider = new ArrayDataProvider([
    'allModels' => $data,
    'sort' => [
        'attributes' => ['id', 'username', 'email'],
    ],
    'pagination' => [
        'pageSize' => 3,
    ],
]);

$a = ['a' => 'aa', 'b' => 'bb', 'c' => 'cc', 'd' => 'dd'];
$b = ['a' => 'aa', 'b' => 'bb','d' => 'dd', 'c' => 'cc'];
if(array_diff($a, $b)) {
    print_r($a);
}

echo \yii\grid\GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        'id', 'username', 'email'
    ]
    ]);