<?php


namespace dictionary\models\queries;



class DictSchoolsQuery extends \yii\db\ActiveQuery
{
    /**
     * @param $country_id
     * @return $this
     */
    public function country($country_id)
    {
        return $this->andWhere(['country_id' => $country_id]);
    }

    /**
     * @param $region_id
     * @return $this
     */
    public function region($region_id)
    {
        return $this->andWhere(['region_id' => $region_id]);
    }

    /**
     * @param $region_id
     * @param $country_id
     * @return $this
     */
    public function countryAndRegion($region_id, $country_id)
    {
        return $this->andWhere(['region_id' => $region_id, 'country_id' => $country_id]);
    }

}