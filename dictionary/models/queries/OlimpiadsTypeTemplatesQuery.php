<?php


namespace dictionary\models\queries;


use olympic\models\SpecialTypeOlimpic;

class OlimpiadsTypeTemplatesQuery extends \yii\db\ActiveQuery
{
    /**
     * @param $number_of_tours
     * @param $form_of_passage
     * @param $edu_level_olymp
     * @param  $year
     * @return $this
     */

    public function templatesOlympicTypeAllNoSpecial($number_of_tours, $form_of_passage,  $edu_level_olymp, $year) {
        return $this->andWhere([
            'number_of_tours' => $number_of_tours,
            'form_of_passage' => $form_of_passage,
            'edu_level_olimp' => $edu_level_olymp,
            'year' => $year ])
            ->andWhere(['is', 'special_type', null])
            ->orderBy(['range'=> SORT_ASC]);
    }

    /**
     * @paran $olympic_id
     * @return $this
     */

    public function templatesOlympicTypeAllSpecial($olympic_id, $year) {
        return $this->alias('ott')
            ->innerJoin(SpecialTypeOlimpic::tableName() . ' sto', 'sto.special_type_id = ott.special_type')
            ->andWhere(['sto.olimpic_id' => $olympic_id])
            ->andWhere(['ott.year' => $year])
            ->orderBy(['ott.range'=> SORT_ASC]);
    }

}