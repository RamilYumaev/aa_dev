<?php
namespace modules\dictionary\models\queries;

use dictionary\helpers\DictFacultyHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\helpers\AnketaHelper;
use yii\db\ActiveQuery;

class SettingEntrantQuery extends ActiveQuery
{
    public function eduForm($eduForm) {
        return $this->andWhere(['form_edu' => $eduForm]);
    }

    public function eduLevel($eduLevel) {
        return $this->andWhere(['edu_level' => $eduLevel]);
    }

    public function specialRight($specialRight) {
        return $this->andWhere(['special_right' => $specialRight]);
    }

    public function eduFinance($specialRight) {
        return $this->andWhere(['finance_edu' => $specialRight]);
    }

    public function type($type) {
        return $this->andWhere(['type' => $type]);
    }

    public function faculty($faculty) {
        return $this->andWhere(['faculty_id' => $faculty]);
    }

    public function isVi($isVi) {
        return $this->andWhere(['is_vi' => $isVi]);
    }

    public function dateEnd() {
        return $this->andWhere(['>', 'datetime_end',  date("Y-m-d H:i:s")]);
    }

    public function eduLevelOpen($eduLevel): bool
    {
        return $this->eduLevel($eduLevel)->dateEnd()->exists();
    }

    public function groupData($eduLevel, $select): array
    {
        return $this->select($select)->eduLevel($eduLevel)->dateEnd()->groupBy($select)->column();
    }

    public function existsOpen(DictCompetitiveGroup $dictCompetitiveGroup, $type, $isVi): bool
    {
        $keyFaculty = key_exists($dictCompetitiveGroup->faculty_id, DictFacultyHelper::facultyListSetting()) ?
                $dictCompetitiveGroup->faculty_id : AnketaHelper::HEAD_UNIVERSITY;
        return $this->faculty($keyFaculty)
            ->type($type)
            ->eduLevel($dictCompetitiveGroup->edu_level)
            ->eduForm($dictCompetitiveGroup->education_form_id)
            ->eduFinance($dictCompetitiveGroup->financing_type_id)
            ->specialRight($dictCompetitiveGroup->special_right_id)
            ->isVi($isVi)
            ->dateEnd()->exists();
    }
}