<?php

namespace frontend\widgets\olympic\gird\user;

use common\auth\helpers\UserSchoolHelper;
use common\helpers\DateTimeCpuHelper;
use olympic\helpers\DiplomaHelper;
use olympic\models\OlimpicList;
use testing\helpers\TestAttemptHelper;
use testing\helpers\TestHelper;
use common\helpers\EduYearHelper;
use testing\helpers\TestResultHelper;
use testing\models\TestAttempt;
use yii\bootstrap\Modal;
use yii\grid\DataColumn;
use yii\helpers\Html;
use yii\jui\Dialog;


class PersonalUserOlympicColumn extends DataColumn
{
    protected function renderDataCellContent($model, $key, $index)
    {
        return  $this->text($model->olympicOne).$model->olympicOne->id;
    }

    private function text(OlimpicList $olympic) {
        if ($olympic->isRegStatus()) {
            return $this->isNoAttemptOrNoEndAttempt($olympic) ? $this->linkTest($olympic) : ($this->textResult($olympic));
        } else {
            return $this->isNoAttemptOrNoEndAttempt($olympic) ? $this->linkDiploma($olympic) : ($this->textResult($olympic))."<br />".$this->linkDiploma($olympic);
        }
    }

    private function linkTest(OlimpicList $olympic) {
        return $this->getTest($olympic) ? Html::a("Начать заочный тур", ['/test/start',
            'id'=> $this->getTest($olympic)],
            ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle'
            =>'Заочный тур', 'class' =>'btn btn-primary'] ):"";
    }

    private function linkDiploma(OlimpicList $olympic) {
        return  $this->getDiploma($olympic) ? Html::a(is_null($this->getDiploma($olympic)->reward_status_id) ?"Сертификат":"Диплом", ['diploma/index', 'id'=> $this->getDiploma($olympic)->id]) :"";
    }

    private function getClassUser() {
        return  UserSchoolHelper::userClassId($this->getUser(), EduYearHelper::eduYear());
    }

    private function getUser() {
        return \Yii::$app->user->identity->getId();
    }

    private function getTest(OlimpicList $olympic)
    {
        return TestHelper::testAndClassActiveOlympicList($olympic->id, $this->getClassUser());
    }

    private function getAttempt(OlimpicList $olympic)
    {
        return TestAttemptHelper::Attempt($this->getTest($olympic), $this->getUser());
    }

    private function isNoAttemptOrNoEndAttempt(OlimpicList $olympic) {
        return !$this->getAttempt($olympic) || $this->getAttempt($olympic)->isAttemptNoEnd();
    }

    private function getDiploma(OlimpicList $olympic) {
        return DiplomaHelper::diplomaId($this->getUser(), $olympic->id);
    }

    private function textResult(OlimpicList $olympic) {
        /** @var  $attempt TestAttempt */
        $attempt = $this->getAttempt($olympic);
        if (TestResultHelper::isPreResult($attempt->id)) {
            return "Оценка появится после завершение заочного тура";
        } elseif(TestResultHelper::isPreResultAll($attempt->id)) {
            return "Предварительная оценка ".$attempt->mark.
                " балла(-ов), итоговая оценка будет известна после окончания заочного тура";
        } else {
            return $olympic->isFormOfPassageDistantInternal() && $olympic->isResultEndTour() ?
                $this->getMarkFormOfPassageDistantInternal($attempt, $olympic) : ($attempt->mark ?? 0);
        }
    }

    private function getMarkFormOfPassageDistantInternal(TestAttempt $attempt, OlimpicList $olimpic) {
        Modal::begin([
            'header' => '<h2>Информация</h2>',
            'toggleButton' => [
                'label' => $attempt->mark,
                'tag' => 'button',
                'style' => ['color'=> $attempt->isRewardMember() ? 'green': 'red'],
            ],
        ]);
        echo $attempt->isRewardMember() ? 'Вы прошли в заключительный этап, который состоится' . DateTimeCpuHelper::getDateChpu($olimpic->date_time_start_tour) . ' года в ' . DateTimeCpuHelper::getTimeChpu($olimpic->date_time_start_tour). ' по адресу: '.$olimpic->address :'К сожалению Вы не прошли в заключительный тур';
        Modal::end();
    }
}