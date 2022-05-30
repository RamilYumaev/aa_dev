<?php

use backend\widgets\adminlte\grid\GridView;

/* @var $this yii\web\View */
/* @var $provider yii\data\ArrayDataProvider */
/* @var $keys array */
/* @var $name string */

$this->title = $name;
$this->params['breadcrumbs'][] = ['label' => 'Справочник суперсервиса', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;

array_unshift($keys, ['class' => \yii\grid\SerialColumn::class]);
$data['rowOptions'] = function($model){
    return ['class' => 'warning'];
};

$data['afterRow'] =function ($model, $key, $index, $grid) {
    if(key_exists('FieldsDescription', $model)) {
        $text = '';
        $text .= '<tr>';
        // var_dump($model['FieldsDescription']['FieldDescription']);
        foreach ($model['FieldsDescription']['FieldDescription'] as $key2 => $value) {
            if(is_array($value)) {
                $text .= '<tr>';
                foreach ($value as $key1 => $value1) {
                    $text .= '<td>'.$key1.": " . $value1.'</td>';
                }
                $text .= '</tr>';
            }else {
                $text .= '<td>'.$key2.":". $value.'</td>';
            }
        }
        $text .= '</tr>';
      return $text;
    }
};
$setting = [
    'dataProvider' => $provider,
    'columns' => $keys,
    ];
$setting = array_merge($data, $setting);
?>
<div class="user-index">
    <div class="box">
        <div class="box-body table-responsive">
            <?= GridView::widget($setting); ?>
        </div>
    </div>
</div>

