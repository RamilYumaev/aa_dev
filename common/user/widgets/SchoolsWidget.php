<?php

namespace common\user\widgets;
use common\user\readRepositories\UserSchoolReadRepository;
use common\user\readRepositories\UserTeacherReadRepository;
use olympic\helpers\auth\ProfileHelper;
use yii\base\Widget;

class SchoolsWidget extends Widget
{
    public  $role;
    private $userSchoolReadRepository;
    private $teacherReadRepository;

    public function __construct( UserSchoolReadRepository $userSchoolReadRepository,
                                 UserTeacherReadRepository $teacherReadRepository,$config = [])
    {
        $this->teacherReadRepository = $teacherReadRepository;
        $this->userSchoolReadRepository = $userSchoolReadRepository;
        parent::__construct($config);
    }

    public function run()
    {
        $dataProvider = $this->getDataProvider(\Yii::$app->user->identity->getId());
        return $this->render($this->getPathView(), [
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function getDataProvider($user) {
        if ($this->role == ProfileHelper::ROLE_TEACHER) {
            return $this->teacherReadRepository->getUserSchoolsAll($user);
        }
        return $this->userSchoolReadRepository->getUserSchoolsAll($user);
    }

    protected function getPathView() {
        if ($this->role == ProfileHelper::ROLE_TEACHER) {
            return 'schools-teacher/index';
        }
         return 'schools-user/index';
    }
}
