<?php
namespace dictionary\readRepositories;

use dictionary\models\DictSchools;

class DictSchoolsReadRepository
{
    public function getAllSchools ($region_id, $country_id)
    {
        $model = DictSchools::find();
        if (!$region_id) {
            $model = $model->country($country_id);
        } else {
            $model = $model->countryAndRegion($region_id, $country_id);
        }
        $result = [];
        foreach ($model->all() as $school) {
            $result[] = [
                'id' => $school->id,
                'text' => $school->name
            ];
        }
        return $result;
    }
}