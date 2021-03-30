<?php


namespace dictionary\models\queries;



class DictDisciplineQuery extends \yii\db\ActiveQuery
{
    public function cseColumnsAll() {
        return $this->joinWith('cse')
            ->andWhere(['not',['cse_subject_id' => null]])
            ->indexBy('dict_discipline.id')
            ->select('dict_cse_subject.name')
            ->column();
    }

    public function columnAll() {
        return $this
            ->indexBy('id')
            ->select('name')
            ->column();
    }

    public function ctColumnsAll() {
        return $this->joinWith('ct')
            ->andWhere(['not',['ct_subject_id' => null]])
            ->indexBy('dict_discipline.id')
            ->select('dict_ct_subject.name')
            ->column();
    }
}