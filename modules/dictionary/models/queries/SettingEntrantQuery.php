<?php
namespace modules\dictionary\models\queries;

use dictionary\helpers\DictFacultyHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\dictionary\models\SettingEntrant;
use Yii;
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

    public function isCseAsVi($isVi) {
        return $this->andWhere(['cse_as_vi' => $isVi]);
    }

    public function dateStart() {
        return $this->andWhere(['<', 'datetime_start',  date("Y-m-d H:i:s")]);
    }

    public function dateEnd() {
        return $this->andWhere(['>', 'datetime_end',  date("Y-m-d H:i:s")]);
    }

    public function tpgu($isStatus) {
        return $this->andWhere(['tpgu_status' => $isStatus]);
    }

    public function foreign($isStatus) {
        return $this->andWhere(['foreign_status' => $isStatus]);
    }

    public function eduLevelOpen($eduLevel): bool
    {
        return $this->eduLevel($eduLevel)->dateStart()->dateEnd()->exists();
    }

    public function isOpenZukApplication($faculty, $eduLevel, $specialRight, $tpgu, $foreign) {
        return $this->faculty($faculty)
            ->type(SettingEntrant::ZUK)
            ->eduLevel($eduLevel)
            ->specialRight($specialRight)
            ->tpgu($tpgu)
            ->foreign($foreign)
            ->dateStart()
            ->dateEnd()
            ->exists();
    }

    public function groupData($eduLevel, $select): array
    {
        return $this->select($select)->eduLevel($eduLevel)->dateStart()->dateEnd()->groupBy($select)->column();
    }

    public function existsOpen(DictCompetitiveGroup $dictCompetitiveGroup, $type): bool
    {
        $keyFaculty = DictFacultyHelper::getKeyFacultySetting($dictCompetitiveGroup->faculty_id);
        return $this->faculty($keyFaculty)
            ->type($type)
            ->eduLevel($dictCompetitiveGroup->edu_level)
            ->eduForm($dictCompetitiveGroup->education_form_id)
            ->eduFinance($dictCompetitiveGroup->financing_type_id)
            ->foreign($dictCompetitiveGroup->foreigner_status)
            ->tpgu($dictCompetitiveGroup->tpgu_status)
            ->specialRight($dictCompetitiveGroup->special_right_id)
            ->isVi($dictCompetitiveGroup->isExamOch())
            ->dateStart()
            ->dateEnd()
            ->exists();
    }

    public function oneDictCompetitiveGroup(DictCompetitiveGroup $dictCompetitiveGroup): ?SettingEntrant
    {
        $keyFaculty = DictFacultyHelper::getKeyFacultySetting($dictCompetitiveGroup->faculty_id);
        return $this->faculty($keyFaculty)
            ->type(SettingEntrant::ZOS)
            ->eduLevel($dictCompetitiveGroup->edu_level)
            ->eduForm($dictCompetitiveGroup->education_form_id)
            ->eduFinance($dictCompetitiveGroup->financing_type_id)
            ->specialRight($dictCompetitiveGroup->special_right_id)
            ->foreign($dictCompetitiveGroup->foreigner_status)
            ->tpgu($dictCompetitiveGroup->tpgu_status)
            ->isVi($dictCompetitiveGroup->isExamOch())
            ->one();
    }

    public function existsFormEduOpen(DictCompetitiveGroup $dictCompetitiveGroup, $type): bool
    {
        $keyFaculty = DictFacultyHelper::getKeyFacultySetting($dictCompetitiveGroup->faculty_id);
        return $this->faculty($keyFaculty)
            ->type($type)
            ->eduLevel($dictCompetitiveGroup->edu_level)
            ->eduForm($dictCompetitiveGroup->education_form_id)
            ->eduFinance($dictCompetitiveGroup->financing_type_id)
            ->foreign($dictCompetitiveGroup->foreigner_status)
            ->tpgu($dictCompetitiveGroup->tpgu_status)
            ->specialRight($dictCompetitiveGroup->special_right_id)
            ->dateStart()
            ->dateEnd()
            ->exists();
    }

    public function isOpenFormZUK(DictCompetitiveGroup $dictCompetitiveGroup)
    {
        $swichUserId = \Yii::$app->session->get('user.idbeforeswitch');
        if(Yii::$app->authManager->getAssignment('entrant', $swichUserId)) {
            return true;
        }
        return $this->existsFormEduOpen($dictCompetitiveGroup, SettingEntrant::ZUK);
    }

    public function isOpenZUK(DictCompetitiveGroup $dictCompetitiveGroup)
    {
        $swichUserId = \Yii::$app->session->get('user.idbeforeswitch');
        if(Yii::$app->authManager->getAssignment('entrant', $swichUserId)) {
            return true;
        }
        return $this->existsOpen($dictCompetitiveGroup, SettingEntrant::ZUK);
    }

    public function isOpenZID(DictCompetitiveGroup $dictCompetitiveGroup)
    {

        $swichUserId = \Yii::$app->session->get('user.idbeforeswitch');
        if(Yii::$app->authManager->getAssignment('entrant', $swichUserId)) {
            return true;
        }
        return $this->existsOpen($dictCompetitiveGroup, SettingEntrant::ZID);
    }

}