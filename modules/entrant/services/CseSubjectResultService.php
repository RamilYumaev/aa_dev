<?php
namespace modules\entrant\services;


use common\auth\models\UserSchool;
use common\auth\repositories\UserSchoolRepository;
use modules\entrant\forms\CseSubjectMarkForm;
use modules\entrant\forms\CseSubjectResultForm;
use modules\entrant\models\CseSubjectResult;
use modules\entrant\repositories\CseSubjectResultRepository;
use supplyhog\ClipboardJs\ClipboardJsAsset;
use yii\helpers\Json;

class CseSubjectResultService
{

    private $repository;

    public function __construct(CseSubjectResultRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(CseSubjectResultForm $form)
    {
        $model  = CseSubjectResult::create($form, $this->dataJson($form->resultData));
        $this->repository->save($model);
        return $model;
    }

    public function edit($id, CseSubjectResultForm $form)
    {
        $model = $this->repository->get($id);
        $model->data($form, $this->dataJson($form->resultData));
        $model->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }

    public function dataJson(array $form) {
        $array = [];
        foreach ($form as $value) {
            $array[$value->subject_id] = $value->mark;
        }
        return Json::encode($array, JSON_NUMERIC_CHECK);
    }
}