<?php
use yii\helpers\Html;
use olympic\helpers\OlympicHelper;
use dictionary\helpers\DictFacultyHelper;
use common\helpers\DateTimeCpuHelper;
use frontend\widgets\olympicold\OlympicOldWidget;


/* @var $this yii\web\View */
/* @var $olympic \olympic\models\Olympic */
/* @var $model \olympic\forms\SignupOlympicForm */


$this->title = $olympic->name;
?>
<div class="container-fluid">
    <p align="right"></p>
    <h1 align="center"><?= Html::encode($olympic->name) ?></h1>
    <div class="row">
        <div class="col-md-4">
            <p align="center"></p>
        </div>
        <div class="col-md-4">
            <p align="center">Количество
                туров: <?= $olympic->olympicOneLast->number_of_tours ? OlympicHelper::numberOfToursName($olympic->olympicOneLast->number_of_tours) : 'Данные обновляются.' ?>
                <br/><?= $olympic->olympicOneLast->only_mpgu_students ? 'Только для студентов МПГУ' : '' ?>
            </p>
        </div>

        <div class="col-md-4">
            <p align="center">Форма(ы) проведения: <?= $olympic->olympicOneLast->form_of_passage ? OlympicHelper::formOfPassageName($olympic->olympicOneLast->form_of_passage)  : 'Данные обновляются.'?></p>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-7">
            <p><strong>Дата и время начала регистрации на сайте:</strong> <?= $olympic->olympicOneLast->date_time_start_reg ?
                    DateTimeCpuHelper::getDateChpu($olympic->olympicOneLast->date_time_start_reg)
                    . ' в ' . DateTimeCpuHelper::getTimeChpu($olympic->olympicOneLast->date_time_start_reg)
                    : 'Данные обновляются.' ?></p>
            <p><strong>Дата и время завершения регистрации на сайте:</strong> <?= $olympic->olympicOneLast->date_time_finish_reg ?
                    DateTimeCpuHelper::getDateChpu($olympic->olympicOneLast->date_time_finish_reg)
                    . ' в ' . DateTimeCpuHelper::getTimeChpu($olympic->olympicOneLast->date_time_finish_reg)
                    : 'Данные обновляются.' ?></p>
            <p>
                <?= $olympic->olympicOneLast->time_of_distants_tour
                    ? '<strong>Продолжительность выполнения заданий заочного тура:</strong> ' . $olympic->olympicOneLast->time_of_distants_tour
                    . ' мин.' : '' ?>
            </p>
            <p>
                <?= $olympic->olympicOneLast->date_time_start_tour ? '<strong>Дата и время проведения очного тура:</strong> '
                    . DateTimeCpuHelper::getDateChpu($olympic->olympicOneLast->date_time_start_tour) . ' в '
                    . DateTimeCpuHelper::getTimeChpu($olympic->olympicOneLast->date_time_start_tour) : '' ?>
            </p>
            <p>
                <?= $olympic->olympicOneLast->address ? '<strong>Адрес проведения очного тура:</strong> ' . $olympic->olympicOneLast->address : '' ?>
            </p>
            <p>
                <?= $olympic->olympicOneLast->time_of_tour ? '<strong>Продолжительность очного тура:</strong> ' . $olympic->olympicOneLast->time_of_tour . ' мин.' : '' ?>

            </p>

            <?= $olympic->olympicOneLast->content ? '<div class="mt-30">' . $olympic->olympicOneLast->content . '</div>' : ''; ?>

            <?= $this->render('_form', ['model' => $model]) ?>

        </div>
        <div class="col-md-5">
            <div class="control-panel">
                <a href="/print/olimp-docs?tempId=2&amp;olimpId=1">Положение</a><br><a href="/print/olimp-docs?tempId=5&amp;olimpId=1">Регламент</a><br><br>
                <a href="/print/olimp-result?olimpId=1">Результаты олимпиады</a><br>
                <?= OlympicOldWidget::widget(['model' => $olympic]) ?>
            </div>
            <p class><a href="olympiads">Посмотреть другие олимпиады &gt;</a></p>
        </div>
    </div>
</div>
