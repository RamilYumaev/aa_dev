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

    /**
     * @param $dict_school_report_id
     * @return $this
     */
    public function dictSchoolReportId($dict_school_report_id)
    {
        return $this->andWhere(['dict_school_report_id'=> $dict_school_report_id]);
    }

    /**
     * @param $dict_school_report_id
     * @return $this
     */
    public function notDictSchoolReportId()
    {
        return $this->andWhere(['is', 'dict_school_report_id', new \yii\db\Expression('null')]);
    }

}