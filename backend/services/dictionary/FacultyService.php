<?php

namespace backend\services\dictionary;

use backend\forms\dictionary\FacultyForm;
use backend\repositories\dictionary\FacultyRepository;
use backend\models\dictionary\Faculty;


class FacultyService
{
    private $facultyRepository;

    public function __construct(FacultyRepository $facultyRepository)
    {
        $this->facultyRepository = $facultyRepository;
    }

    public function create(FacultyForm $form)
    {
        $faculty = Faculty::create($form->full_name);
        $this->facultyRepository->save($faculty);
        return $faculty;
    }

    public function edit($id, FacultyForm $form)
    {
        $faculty = $this->facultyRepository->get($id);
        $faculty->edit($form->full_name);
        $this->facultyRepository->save($faculty);
    }

    public function remove($id)
    {
        $faculty = $this->facultyRepository->get($id);
        $this->facultyRepository->remove($faculty);
    }
}