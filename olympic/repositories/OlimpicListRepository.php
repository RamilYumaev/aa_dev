<?php

namespace olympic\repositories;

use common\helpers\EduYearHelper;
use olympic\helpers\OlympicHelper;
use olympic\models\OlimpicList;
use olympic\models\Olympic;
use yii\web\HttpException;

class OlimpicListRepository
{

    public function getEduYear($id): OlimpicList
    {
        if (!$model = OlimpicList::findOne(['id' => $id, 'year' => EduYearHelper::eduYear() ])) {
            throw new \DomainException('Данная олимпиада не имеет запись на '.EduYearHelper::eduYear(). ' учебынй год!');
        }
        return $model;
    }

    public function get($id): OlimpicList
    {
        if (!$model = OlimpicList::findOne($id)) {
            throw new HttpException('403', "Нет такой олимпиады");
        }
        return $model;
    }

    public function getManager($id)
    {
        if (($model = Olympic::find()->andWhere(['id'=>$id])
                ->andWhere(['id'=>OlympicHelper::olympicManagerList()])->one()) !== null) {
            return $model;
        }
       throw new HttpException('403', "Вам не разрешено данное действие");
    }

    public function getManagerList($id)
    {
        if (($model = OlimpicList::find()->where(['id'=>$id,'olimpic_id'=>OlympicHelper::olympicManagerList()])->one()) !== null) {
            return $model;
        }
        throw new HttpException('403', "Вам не разрешено данное действие");
    }


    public function isFinishDateRegister($id): OlimpicList
    {
        if (!$model = OlimpicList::find()->andWhere(['id'=> $id ])
            ->andWhere(['<','date_time_finish_reg', date('Y-m-d H:i:s')])
            ->one()) {
            throw new \DomainException('Результаты можно подводить после окончания регистрации или заочного тура!.');
        }
        return $model;
    }

    public function save(OlimpicList $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(OlimpicList $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}