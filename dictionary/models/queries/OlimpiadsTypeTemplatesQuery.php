<?php


namespace dictionary\models\queries;


use olympic\models\SpecialTypeOlimpic;
use yii\db\ActiveRecord as ActiveRecordAlias;

class OlimpiadsTypeTemplatesQuery extends \yii\db\ActiveQuery
{
    /**
     * @param $number_of_tours
     * @param $form_of_passage
     * @param $edu_level_olymp
     * @return array|ActiveRecordAlias[]
     */

    public function templatesOlympicTypeAllNoSpecial($number_of_tours, $form_of_passage,  $edu_level_olymp) {
        return $this->andWhere([
            'number_of_tours' => $number_of_tours,
            'form_of_passage' => $form_of_passage,
            'edu_level_olimp' => $edu_level_olymp])
            ->andWhere(['is', 'special_type', null])->all();
    }

    /**
     * @paran $olympic_id
     * @return array|ActiveRecordAlias[]
     */

    public function templatesOlympicTypeAllSpecial($olympic_id) {
        return $this->alias('ott')
            ->innerJoin(SpecialTypeOlimpic::tableName() . ' sto', 'sto.special_type_id = ott.special_type')
            ->andWhere(['sto.olimpic_id' => $olympic_id])->all();
    }

}