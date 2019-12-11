<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model testing\forms\question\TestQuestionForm*/

$this->title = 'Создать "Развернутый ответ"';
$olympic_id = Yii::$app->request->get('olympic_id');
$this->params['breadcrumbs'][] = ['label' => 'Олимпиады/конкурсы', 'url' => ['olympic/olympic/index']];
$this->params['breadcrumbs'][] = ['label' => \olympic\helpers\OlympicHelper::olympicName($olympic_id),
    'url' => ['olympic/olympic/view', 'id'=> $olympic_id]];
$this->params['breadcrumbs'][] = ['label' => 'Вопросы теста "Развернутый ответ"',
    'url' => ['index', 'olympic_id'=> $olympic_id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
<?php $form = ActiveForm::begin(['id' => 'form-question-answer-detailed']); ?>
    <div class="col-md-12">
        <?= $this->render('@backend/views/testing/question/_form-question', ['model' => $model, 'form' => $form,  'id' => '']) ?>
    </div>
<?php ActiveForm::end(); ?>
</div>
