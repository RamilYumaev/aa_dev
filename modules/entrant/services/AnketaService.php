<?php


namespace modules\entrant\services;


use modules\dictionary\models\DictCategory;
use modules\entrant\forms\AnketaForm;
use modules\entrant\models\Anketa;
use modules\entrant\repositories\AnketaRepository;

class AnketaService
{
    private $repository;

    public function __construct(AnketaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(AnketaForm $form)
    {
        $model = Anketa::create($form);
        $this->repository->save($model);
        return $model;
    }

    public function update($id, AnketaForm $form)
    {
        $model = $this->repository->get($id);
        $model->data($form);
        $model->save($model);
    }

    public function category($foreignerStatus)
    {
        $category = DictCategory::find()
            ->andWhere(['foreigner_status' => $foreignerStatus])
            ->all();

        $result = [];

        foreach ($category as $item)
        {
            $result[] = [
                'id' => $item->id,
                'text' => $item->name,
                ];

        }
        return $result;


    }

}