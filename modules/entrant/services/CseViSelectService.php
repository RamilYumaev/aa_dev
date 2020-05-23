<?php
namespace modules\entrant\services;


use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\forms\ExaminationOrCseForm;
use modules\entrant\models\CseViSelect;
use modules\entrant\repositories\CseViSelectRepository;
use yii\helpers\Json;

class CseViSelectService
{
    private $repository;


    public function create(ExaminationOrCseForm $form, $user_id, CseViSelectRepository $repository)
    {
        if($cseViSelect =  $repository->getUser($user_id)) {
            $cseViSelect->data($this->dataJsonVi($form->arrayMark), $this->dataJsonCse($form->arrayMark), $user_id);
        }else {
            $cseViSelect  = CseViSelect::create($this->dataJsonVi($form->arrayMark), $this->dataJsonCse($form->arrayMark), $user_id);
        }
        \Yii::$app->session->setFlash("success",'Успешно сохранено');
        $repository->save($cseViSelect);
    }

    public function dataJsonVi(array $form) {
        $array = [];
        foreach ($form as $key =>$value) {
            if($value->type) {
               continue;
            }
            $array[$key] =  $value->language ?? $key;
        }
        return Json::encode($array, JSON_NUMERIC_CHECK);
    }

    public function dataJsonCse(array $form) {
        $array = [];
        foreach ($form as $key => $value) {
            if(!$value->type) {
                continue;
            }
            $array [$key] [0]= $value->year;
            $array [$key] [1]= $value->language ?? DictCompetitiveGroupHelper::cseSubjectId($key);
            $array [$key] [2]= $value->mark;

        }
        return Json::encode($array, JSON_NUMERIC_CHECK);
    }



}