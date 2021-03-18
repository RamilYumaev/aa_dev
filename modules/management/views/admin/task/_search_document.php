<?php
/* @var $this yii\web\View */
/* @var $searchModel modules\management\models\RegistryDocument */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $type integer*/
/* @var $task  modules\management\models\Task*/

use modules\entrant\helpers\SelectDataHelper;
use yii\grid\GridView;
use yii\helpers\Html;
$this->title = "Поиск и прекрепление документа к задаче";
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['task/index']];
$this->params['breadcrumbs'][] = ['label' => $task->title, 'url' => ['task/view', 'id' => $task->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alert alert-success alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <strong></strong>
</div>
<div class="box">
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => \yii\grid\SerialColumn::class],
                [ 'attribute' => 'name' , 'format' => 'raw',
                    'value' => function($model) {
                        return Html::a($model->name, $model->link ? $model->link : $model->getUploadedFileUrl('file'));
                    }],
                [ 'attribute' => 'category_document_id' ,
                    'filter' => SelectDataHelper::dataSearchModel($searchModel, \modules\management\models\CategoryDocument::find()->allColumn(),
                        'category_document_id', 'categoryDocument.name'),
                    'value' =>  'categoryDocument.name'],
                [ 'attribute' => 'access' ,
                    'filter' => (new \modules\management\models\RegistryDocument())->getAccessList(),
                    'value' =>  'accessName'],
                ['class' => 'yii\grid\CheckboxColumn',
                    'multiple' => false,
                    'checkboxOptions' => function (\modules\management\models\RegistryDocument $model, $key, $index, $column) use($task) {
                      return [
                              'checked' => $model->getDocumentTask()->where(['task_id' =>$task->id])->exists() ? true : false,
                              'onchange' =>
                         '$.get("/management-admin/task/select-document?id='.$task->id.'&document_id='.$model->id.'&check="+$(this).is(":checked"), 
                         function(data) { if(data=="Добавлен!") {
                     $(".alert").attr("class", "alert alert-success alert-dismissible fade in");
                  }
                  else {
                     $(".alert").attr("class", "alert alert-warning alert-dismissible fade in");
                  }
                  $(".alert").fadeIn(); 
                  $("div.alert strong").html(data);
                   })'];}
                ],
            ]
        ]); ?>
    </div>
</div>
<?php
$script = <<< JS
jQuery('.alert').hide();
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>


