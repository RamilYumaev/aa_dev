<?php
namespace olympic\traits;

use common\helpers\EduYearHelper;
use dictionary\helpers\DictFacultyHelper;
use dictionary\models\DictSchools;
use dictionary\models\DictSchoolsReport;
use dictionary\repositories\DictSchoolsReportRepository;
use dictionary\repositories\DictSchoolsRepository;
use dod\forms\SignupDodForm;
use olympic\forms\auth\SchooLUserCreateForm;
use olympic\forms\SignupOlympicForm;
use olympic\helpers\OlympicHelper;
use olympic\models\OlimpicList;

trait NewOrRenameSchoolTrait
{

    public function newOrRenameSchoolRegisterOlympicId(SignupOlympicForm $form, DictSchoolsRepository $schoolsRepository) : int
    {
        return  $this->newOrRenameSchoolDefaultId($form->schoolUser, $form->profile, $schoolsRepository);
    }

    public function newOrRenameSchoolRegisterDodId(SignupDodForm $form, DictSchoolsRepository $schoolsRepository) : int
    {
        return  $this->newOrRenameSchoolDefaultId($form->schoolUser, $form->profile, $schoolsRepository);
    }

    public function newOrRenameSchoolId(SchooLUserCreateForm $form, DictSchoolsRepository $schoolsRepository) : int
    {
        return  $this->newOrRenameSchoolDefaultId($form->schoolUser, $form, $schoolsRepository);
    }

    public function newOrRenameSchoolDefaultId($userSchoolForm, $profileForm, DictSchoolsRepository $schoolsRepository) : int
    {
        if ($userSchoolForm->check_region_and_country_school &&
            $userSchoolForm->check_new_school &&
            $userSchoolForm->new_school) {
            $schoolsRepository->getFull($userSchoolForm->new_school, $profileForm->country_id, $profileForm->region_id);
            $school = DictSchools::create($userSchoolForm->new_school, $profileForm->country_id, $profileForm->region_id);
        } elseif (!$userSchoolForm->check_region_and_country_school &&
            $userSchoolForm->check_new_school &&
            $userSchoolForm->new_school) {
            $schoolsRepository->getFull($userSchoolForm->new_school, $userSchoolForm->country_school, $userSchoolForm->region_school);
            $school = DictSchools::create($userSchoolForm->new_school, $userSchoolForm->country_school, $userSchoolForm->region_school);
        } elseif ($userSchoolForm->check_region_and_country_school &&
            $userSchoolForm->check_rename_school &&
            $userSchoolForm->new_school) {
            $school = $schoolsRepository->get($userSchoolForm->school_id);
            $school->edit($userSchoolForm->new_school, $profileForm->country_id, $profileForm->region_id);
        } elseif (!$userSchoolForm->check_region_and_country_school &&
            $userSchoolForm->check_rename_school &&
            $userSchoolForm->new_school) {
            $school = $schoolsRepository->get($userSchoolForm->school_id);
            $school->edit($userSchoolForm->new_school, $userSchoolForm->country_school, $userSchoolForm->region_school);
        } else {
            $school = $schoolsRepository->get($userSchoolForm->school_id);
        }
        $schoolsRepository->save($school);
        $this->addNewSchoolReport($school->id, $schoolsRepository);
        return $school->id;
    }

    private function addNewSchoolReport($id, DictSchoolsRepository $schoolsRepository) {
        $modelOne = $schoolsRepository->get($id);
        if(is_null($modelOne->dict_school_report_id)) {
            $reportModel = DictSchoolsReport::create($modelOne->id);
            $repository = new DictSchoolsReportRepository();
            $repository->save($reportModel);
            $modelOne->setDictSchoolReportId($reportModel->id);
            $schoolsRepository->save($modelOne);
        }
    }
}