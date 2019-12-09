<?php

namespace frontend\widgets\olympic\gird\user;

use common\auth\helpers\UserSchoolHelper;
use testing\helpers\TestHelper;
use common\helpers\EduYearHelper;
use yii\grid\DataColumn;


class PersonalUserOlympicColumn extends DataColumn
{
    protected function renderDataCellContent($model, $key, $index): string
    {
        return $test ? \yii\helpers\Html::a("Начать заочный тур", ['/test-attempt/start', 'test_id'=> $test],
        ['data' => ['confirm' => 'Вы действительно хотите начать заочный тур ?', 'method' => 'POST'],
            'class' =>'btn btn-primary'] ): "";
    }


    private function getClassUser() {
        return  UserSchoolHelper::userClassId( $this->getUser(), EduYearHelper::eduYear());
    }

    private function getUser() {
        return \Yii::$app->user->identity->getId();
    }

    private function getTest($model)
    {
        return TestHelper::testAndClassActiveOlympicList($model->olympicOne->id, $this->getClassUser());
    }


    private function getAttempt() {

    }

}