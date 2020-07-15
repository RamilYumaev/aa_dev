<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model testing\forms\question\TestQuestionForm*/

$this->title = 'Создать "Развернутый ответ"';

$this->params['breadcrumbs'][] = ['label' => 'Вопросы','url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_form',['model'=> $model ]);
