<?php
namespace modules\dictionary\services;

use common\transactions\TransactionManager;
use modules\dictionary\models\TestingEntrant;
use modules\dictionary\models\TestingEntrantDict;
use modules\dictionary\repositories\TestingEntrantRepository;
use modules\usecase\ServicesClass;
use yii\base\Model;


class TestingEntrantService extends ServicesClass
{

    private $transactionManager;
    public function __construct(TestingEntrantRepository $repository,  TestingEntrant $model,
                                TransactionManager $transactionManager)
    {
        $this->repository = $repository;
        $this->model = $model;
        $this->transactionManager = $transactionManager;
    }

    public function create(Model $form)
    {
        $model = parent::create($form);
        $this->saveRelation($form, $model->id);
        return $model;
    }

    public function edit($id, Model $form)
    {
        $model = $this->repository->get($id);
        $model->data($form);
        if(!$model->status) {
            $this->deleteRelation($id);
            $this->saveRelation($form, $model->id);
        }
        $model->save($model);
    }

    public function status($id, $status)
    {
        $model = $this->repository->get($id);
        $model->setStatus($status);
        $model->save($model);
    }

    public function saveRelation($form, $id) {
        if ($form->dictTestingList) {
            foreach ($form->dictTestingList as $dict) {
                if($this->testEntrantDict($dict, $id)) {
                    continue;
                }
                $this->addNewTesting($dict, $id);
            }
        }
    }

    public function testEntrantDict($dict, $id) {
        return TestingEntrantDict::findOne(['id_dict_testing_entrant' => $dict,
            'id_testing_entrant' => $id]);
    }

    public function addNewTesting($dict, $id) {
        $model = new TestingEntrantDict();
        $model->data($dict, $id);
        $model->save();
    }

    private function deleteRelation($id)
    {
        TestingEntrantDict::deleteAll(['id_testing_entrant' => $id]);
    }

    public function addMessage($dict, $id)
    {
        $model = $this->testEntrantDict($dict, $id);

    }
}