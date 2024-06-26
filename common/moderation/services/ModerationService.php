<?php


namespace common\moderation\services;

use common\auth\models\UserSchool;
use common\moderation\behaviors\ModerationUpdateBehavior;
use common\moderation\helpers\ModerationHelper;
use common\moderation\forms\ModerationMessageForm;
use common\moderation\models\Moderation;
use common\moderation\repositories\BaseRepository;
use common\moderation\repositories\ModerationRepository;
use common\transactions\TransactionManager;
use dictionary\helpers\DictFacultyHelper;
use dictionary\models\DictSchools;
use modules\entrant\models\DocumentEducation;
use modules\management\migrations\m191208_001261_add_primary_key_task_document;
use yii\db\BaseActiveRecord;

class ModerationService
{
    private $repository;
    private $baseRepository;
    private $transactionManager;

    public function __construct(ModerationRepository $repository,
                                BaseRepository $baseRepository,
                                TransactionManager $transactionManager)
    {
        $this->repository = $repository;
        $this->baseRepository = $baseRepository;
        $this->transactionManager = $transactionManager;
    }

    public function take($id)
    {
        $this->transactionManager->wrap(function () use ($id) {
            $moderation = $moderation = $this->getModeration($id, ModerationHelper::STATUS_TAKE);
            $model = $this->getBaseRecordData($moderation->record_id, $moderation->getModel(), $moderation->getAfterData());
            $this->baseRepository->save($model);
            $this->repository->save($moderation);
        });
    }

    public function reject($id, ModerationMessageForm $form)
    {
        $this->transactionManager->wrap(function () use ($id, $form) {
            $moderation = $this->getModeration($id, ModerationHelper::STATUS_REJECT);
            $moderation->setMessage($form->message);
            if ($moderation->getBeforeData()) {
                $model = $this->getBaseRecordData($moderation->record_id, $moderation->getModel(), $moderation->getBeforeData());
                $this->baseRepository->save($model);
            } else {
                $this->baseRepository->remove($this->getBaseRecord($moderation->record_id, $moderation->getModel()));
            }
            $this->repository->save($moderation);
        });
    }

    public function rejectChange($id, $school)
    {
        $this->transactionManager->wrap(function () use ($id, $school) {
            $moderation = $this->getModeration($id, ModerationHelper::STATUS_REJECT_CHANGE);
            if ($moderation->getBeforeData()) {
                $model = $this->getBaseRecordData($moderation->record_id, $moderation->getModel(), $moderation->getBeforeData());
                $this->baseRepository->save($model);
            } else {
                $this->baseRepository->remove($this->getBaseRecord($moderation->record_id, $moderation->getModel()));
            }
            $this->repository->save($moderation);
            $this->handleChangeOrAddSchool($moderation, $school);
        });
    }

    protected function getBaseRecord($id, BaseActiveRecord $baseActiveRecord)
    {
        $model = $this->baseRepository->get($id, $baseActiveRecord);
        $model->detachBehavior('moderation');
        return $model;
    }

    protected function getBaseRecordData($id, BaseActiveRecord $baseActiveRecord, $data)
    {
        $model = $this->getBaseRecord($id, $baseActiveRecord);
        $model->setAttributes($data, false);
        return $model;
    }

    protected function getModeration($id, $status)
    {
        $model = $this->repository->get($id);
        $model->setStatus($status);
        return $model;
    }

    protected function handleChangeOrAddSchool(Moderation $moderation, $school) {
        $oldSchool  = DictSchools::findOne($moderation->record_id);
        if(!$school) {
            $name = $moderation->getAfter('name');
            $countryId = key_exists('country_id', $moderation->getAfterData()) ? $moderation->getAfter('country_id') : $oldSchool->country_id;
            $regionId = key_exists('region_id', $moderation->getAfterData()) ? $moderation->getAfter('region_id') : $oldSchool->region_id;
            $model = DictSchools::create($name, $countryId, $regionId);
            if($model->save()) {
                $this->handleUpdate($moderation, $model->id);
            }
        }else {
            $this->handleUpdate($moderation, $school);
        }
    }

    protected function handleUpdate(Moderation $moderation, $school) {
        $usersSchool = UserSchool::find()
            ->andWhere(['user_id' => $moderation->created_by, 'school_id' => $moderation->record_id])
            ->all();
        /* @var  UserSchool $userSchool*/
        foreach ($usersSchool as $userSchool) {
            $userSchool->detachBehaviors();
            $userSchool->school_id = $school;
            $userSchool->save();
        }
        $documents = DocumentEducation::find()
            ->andWhere(['user_id' => $moderation->created_by, 'school_id' => $moderation->record_id])
            ->all();
        /* @var  DocumentEducation $document*/
        foreach ($documents as $document) {
            $document->detachBehaviors();
            $document->school_id = $school;
            $document->attachBehavior('moderation3', [
                'class' => ModerationUpdateBehavior::class,
                'attributes'=>['school_id','type', 'series', 'number', 'date', 'year',
                    'patronymic', 'surname', 'name', 'other_data',
                    'type_document',
                    'version_document' ],
                'attributesNoEncode' => ['series', 'number'],
            ]);
            $document->save();
        }
    }
}
