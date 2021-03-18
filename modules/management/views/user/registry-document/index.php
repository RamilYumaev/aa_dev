<?php


use modules\entrant\helpers\SelectDataHelper;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;
use dictionary\models\DictClass;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel modules\management\searches\RegistryDocumentSearch*/

$this->title = 'Реестр документов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="box">
        <div class="box-header">
            <?= Html::a('Создать', ['registry-document/create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'=> $searchModel,
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
                    [ 'attribute' => 'dict_department_id' ,
                        'filter' => \modules\management\models\DictDepartment::find()->allColumn(),
                        'value' =>  'dictDepartment.name'],
                    [ 'format' => 'raw',
                        'value' => function($model) {
                            return Html::button('Скопировать ссылку', ['class'=>'btn btn-warning',  'data-clipboard-text'=> $model->link ? $model->link : $model->getUploadedFileUrl('file')]);
                        }],

                ]
            ]); ?>
        </div>
    </div>
</div>
<?php $this->registerJsFile('https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js', ['position' => \yii\web\View::POS_END]);
$this->registerJs(<<<JS
new ClipboardJS('.btn');
JS
)
?>
