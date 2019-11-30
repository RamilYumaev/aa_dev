<?php

namespace testing\readRepositories;

use testing\models\Test;
use testing\models\TestAndQuestions;
use yii\data\Pagination;

class TestReadRepository
{
    public function find($id)
    {
        return Test::findOne($id);
    }

    public function quentTests($id) {

        return  TestAndQuestions::find()->where(['test_id'=> $this->find($id)->id]);
    }

    public function quentTestsCount($id) {
        return $this->quentTests($id)->count();
    }

    public function  pageCount ($id) {
        $pages = new Pagination(['totalCount' =>$this->quentTestsCount($id),
           'pageSize' => 1
        ]);
        return $pages;
    }

    public function  pageOffset ($id) {
        $que= $this->pageCount($id);
        return $this->quentTests($id)
            ->offset($que->offset)
            ->limit($que->limit)
            ->all();
    }
}