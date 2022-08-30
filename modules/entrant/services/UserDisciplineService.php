<?php
namespace modules\entrant\services;


use Cassandra\Set;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\repositories\DictDisciplineRepository;
use modules\dictionary\models\SettingEntrant;
use modules\dictionary\repositories\DictCseSubjectRepository;
use modules\dictionary\repositories\DictCtSubjectRepository;
use modules\entrant\forms\UserDisciplineCseForm;
use modules\entrant\models\UserAis;
use modules\entrant\models\UserDiscipline;
use modules\entrant\repositories\UserDisciplineRepository;

class UserDisciplineService
{
    private $repository;
    private $dictDisciplineRepository;
    private $ctSubjectRepository;
    private $cseSubjectRepository;

    public function __construct(UserDisciplineRepository $repository,
                                DictDisciplineRepository $dictDisciplineRepository,
                                DictCtSubjectRepository $ctSubjectRepository,
                                DictCseSubjectRepository $cseSubjectRepository)
    {
        $this->repository = $repository;
        $this->dictDisciplineRepository = $dictDisciplineRepository;
        $this->ctSubjectRepository = $ctSubjectRepository;
        $this->cseSubjectRepository = $cseSubjectRepository;
    }

    public function create(UserDisciplineCseForm $form)
    {
        $this->correctIdDiscipline($form);
        $model  = UserDiscipline::create($form);
        $this->repository->save($model);
        return $model;
    }

    public function createMore(array $forms) {
        /** @var UserDisciplineCseForm $form */
        foreach ($forms as $form) {
            if($id = $form->key) {
                $this->edit($id, $form);
            }else {
                $this->create($form);
            }
        }
    }

    public function updateStatuses(array $data) {
        foreach ($data as $incomingSubjectCse) {
            $userAis = UserAis::findOne(['incoming_id' => $incomingSubjectCse['incoming_id']]);
            if($userAis) {
                foreach ($incomingSubjectCse['cse_subjects'] as $value) {
                   $cseSubject =  $this->cseSubjectRepository->getForAis($value['subject_id']);
                   if($cseSubject) {
                       $discipline = $this->dictDisciplineRepository->getCse($cseSubject->id);
                       if($discipline) {
                           /** @var UserDiscipline $model */
                           $model = $this->repository->getUserCseDiscipline($discipline->id, $userAis->user_id);
                           if($model) {
                               $model->updateForAis($value['status_id'], $value['year'], $value['mark']);
                               $this->repository->save($model);
                           }
                       }
                   }

                }

            }
        }
    }

    public function createOne(UserDisciplineCseForm $form, $isSpo = false, $foreign = false) {
        if($form->type == UserDiscipline::VI) {
            if(!$foreign && !$this->isOpenCseVi($form->user_id, $form->discipline_id, $isSpo)) {
                throw new  \DomainException("Вы не можете выбрать тип ВИ, как так срок подачи истек");
            }
        }
        if($id = $form->key) {
            $this->edit($id, $form);
        }else {
            $this->create($form);
        }
    }

    public function edit($id, UserDisciplineCseForm $form)
    {
        $this->correctIdDiscipline($form);
        $model = $this->repository->getUser($id, $form->user_id);
        $model->data($form);
        $this->repository->save($model);
    }

    private function correctIdDiscipline(UserDisciplineCseForm $form) {
        $discipline = $this->dictDisciplineRepository->get($form->discipline_id);
        if($discipline->composite_discipline && $form->composite) {
            $discipline = $this->dictDisciplineRepository->get($form->discipline_select_id);
        }
        if ($form->type == UserDiscipline::CSE) {
            $this->cseSubjectRepository->get($discipline->cse_subject_id);
        }
        if ($form->type == UserDiscipline::CT) {
            $this->ctSubjectRepository->get($discipline->ct_subject_id);
        }
    }

    private function isOpenCseVi($userId, $disciplineId, $isSpo) {
        $eduForms = $isSpo ? DictCompetitiveGroupHelper::getFormsFromUserAndDisciplineSpo($userId, $disciplineId):
            DictCompetitiveGroupHelper::getFormsFromUserAndDiscipline($userId, $disciplineId);
        return SettingEntrant::find()->type(SettingEntrant::ZUK)
            ->isCseAsVi(true)
            ->eduForm($eduForms)
            ->foreign(false)
            ->tpgu(false)
            ->eduFinance(DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET)
            ->dateStart()->dateEnd()->exists();
    }

    /**
     * @param $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }
}