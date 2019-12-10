<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TestsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Режим тестирования "'. $model->one()->departOfTests->name.'"';
$this->params['breadcrumbs'][] = $this->title;

?>

<!-- Put this script tag to the <head> of your page -->
<script type="text/javascript" src="//vk.com/js/api/openapi.js?146"></script>

<script type="text/javascript">
  VK.init({apiId: 4965933, onlyWidgets: true});
</script>
<div class="row">
<div class="col-md-6">
<div class="box box-success">
<div class="box-header with-border">
<h3 class="box-title">Тесты</h3>
</div>
 <div class="box-body">
  <?=  GridView::widget([
        'dataProvider' => new yii\data\ActiveDataProvider(['query' => $model ]),
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
          
            'name',
            'usAtR.mark',
             ['attribute' =>'id',
             'value' => function ($model) {    
              
       return  $model->usAtR->timec ? Yii::$app->formatter->asDate($model->usAtR->timec, 'php:d M Y') :""; 

     },
             'header' =>"Дата" ],

           //'mark', 
         ['class' => 'yii\grid\ActionColumn',
          'template' => '{link}',
          'buttons' => [
            'link' => function ($url, $model) {
              $url=Yii::$app->urlManager->createUrl(['testsandedu/timec', 'id' => $model->id, 'type_test_id' => $model->type_test_id]);
             return Html::a('Начать', $url);
           }, 

          ],

            ],
 ],
   ]); 

?>
</div>
  <div class="box-footer">
  </div>
  </div>
  </div></div>

<!-- Put this div tag to the place, where the Comments block will be -->
<div id="vk_comments"></div>
<script type="text/javascript">
VK.Widgets.Comments("vk_comments", {limit: 20, attach: "*"});
</script>


