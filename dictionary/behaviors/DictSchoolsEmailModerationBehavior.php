<?php

namespace dictionary\behaviors;

use common\transactions\TransactionManager;
use common\user\repositories\UserTeacherSchoolRepository;
use dictionary\helpers\DictSchoolsHelper;
use dictionary\models\DictSchools;
use dictionary\repositories\DictSchoolsRepository;
use olympic\services\UserSchoolService;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;

class DictSchoolsEmailModerationBehavior extends  Behavior
{
    public $attributeEmail;
    /**
     * @var BaseActiveRecord
     */
    public $owner;
    private $repository;
    private $teacherSchoolRepository;
    private $transactionManager;
    private $schoolService;


    public function __construct(DictSchoolsRepository $repository,
                                UserTeacherSchoolRepository $teacherSchoolRepository,
                                UserSchoolService $schoolService,
                                TransactionManager $transactionManager, $config = [])
    {
        $this->repository = $repository;
        $this->teacherSchoolRepository = $teacherSchoolRepository;
        $this->transactionManager = $transactionManager;
        $this->schoolService = $schoolService;
        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function events()
    {
        return [
        ActiveRecord::EVENT_AFTER_UPDATE=> 'afterUpdate',
        ];
    }

    /**
     * @param $event
     * @throws \Exception
     */
    public function afterUpdate($event)
    {
        if ($this->owner->model === DictSchools::class) {
            if($this->owner->isStatusTake()) {
                $this->transactionManager->wrap(function () {
                $school = $this->repository->get($this->owner->record_id);
                $school->detachBehavior('moderation');
                $userTeacher = $this->teacherSchoolRepository->getSchool($school->id, $this->owner->created_by);
                if($userTeacher) {
                    $is = $this->owner->getModel()->isIdenticalValue($this->attributeEmail,
                        $this->owner->getBefore($this->attributeEmail), $this->owner->getAfter($this->attributeEmail));
                    if (!$is) {
                        $this->schoolService->send($userTeacher->id, $userTeacher->user_id);
                    }
                }
                $school->setStatus(DictSchoolsHelper::ACTIVE_EMAIL);
                $this->repository->save($school);
            });
            }
        }
    }



}