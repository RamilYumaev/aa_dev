<?php


namespace modules\entrant\services;


use common\transactions\TransactionManager;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use dictionary\repositories\DictCompetitiveGroupRepository;
use modules\dictionary\models\SettingEntrant;
use modules\entrant\helpers\AgreementHelper;
use modules\entrant\helpers\OtherDocumentHelper;
use modules\entrant\models\Anketa;
use modules\entrant\models\UserCg;
use modules\entrant\repositories\CathedraCgRepository;
use modules\entrant\repositories\StatementCgRepository;
use modules\entrant\repositories\StatementRepository;
use modules\entrant\repositories\UserCgRepository;

class ApplicationsService
{
    private $repository;
    public  $repositoryCg;
    private $statementCgRepository;
    private $statementRepository;
    private $transactionManager;
    private $cathedraCgRepository;

    public function __construct(UserCgRepository $repository,
                                CathedraCgRepository $cathedraCgRepository,
                                DictCompetitiveGroupRepository $repositoryCg,
                                StatementCgRepository $statementCgRepository,
                                StatementRepository $statementRepository,
                                TransactionManager $transactionManager)
    {

        $this->repository = $repository;
        $this->repositoryCg = $repositoryCg;
        $this->statementCgRepository = $statementCgRepository;
        $this->transactionManager = $transactionManager;
        $this->statementRepository  = $statementRepository;
        $this->cathedraCgRepository = $cathedraCgRepository;
    }

    public function saveCg($id, $cathedra_id, $anketa) {
        $cg = $this->repositoryCg->get($id);
        if(!SettingEntrant::find()->isOpenZUK($cg))
        {
            throw new \DomainException("Прием документов на данную образовательную программу окончен!");
        }
        DictCompetitiveGroupHelper::oneProgramGovLineChecker($cg);
        DictCompetitiveGroupHelper::noMore3Specialty($cg);
        DictCompetitiveGroupHelper::isAvailableCg($cg);
        DictCompetitiveGroupHelper::budgetChecker($cg);
        $this->repository->haveARecord($cg->id);
        $this->transactionManager->wrap(function() use ($cg, $cathedra_id, $anketa) {
            if ($cathedra_id) {
                $this->cathedraCgRepository->get($cg->id, $cathedra_id);
            }
            $userCg = UserCg::create($cg->id, $cathedra_id);
            $formCategory = DictCompetitiveGroupHelper::formCategory()[$cg->education_form_id];
            $statement = $this->statementRepository->getStatementFull($userCg->user_id,
                $cg->faculty_id, $cg->speciality_id, $cg->special_right_id, $cg->edu_level, $formCategory, $cg->financing_type_id);
            if($statement) {
                if($statement->files) {
                    throw new \DomainException('Вы не можете добавить, так как в заявлении присутствует загруженный файл');
                }
                $statement->setCountPages(0);
                $this->statementRepository->save($statement);
            }
            $this->repository->save($userCg);

            if($cg->isKvota() || $cg->isTarget())
            {
                $shareCg = DictCompetitiveGroup::find()->findBudgetAnalog($cg)->one();
                if($shareCg && !$this->repository->haveARecordSpecialRight($shareCg->id))
                {
                    if(SettingEntrant::find()->isOpenZUK($shareCg)) {
                        $userCg = UserCg::create($shareCg->id, $cathedra_id);
                        $this->repository->save($userCg);
                    }

                }
            }

            /* @var $anketa \modules\entrant\models\Anketa */
        if(OtherDocumentHelper::isExitsExemption($anketa->user_id) && !$cg->isKvota() && $cg->isBudget()) {
            $shareCg = DictCompetitiveGroup::find()->findBudgetAnalog($cg, DictCompetitiveGroupHelper::SPECIAL_RIGHT)->one();
            if($shareCg && !$this->repository->haveARecordSpecialRight($shareCg->id))
            {
                if(SettingEntrant::find()->isOpenZUK($shareCg)) {
                $userCg = UserCg::create($shareCg->id, null);
                $this->repository->save($userCg);
                }
            }
        }

        if(AgreementHelper::isExits($anketa->user_id) && !$cg->isTarget() && $cg->isBudget()) {
                $shareCg = DictCompetitiveGroup::find()->findBudgetAnalog($cg, DictCompetitiveGroupHelper::TARGET_PLACE)->one();
                if($shareCg && !$this->repository->haveARecordSpecialRight($shareCg->id))
                {
                    if(SettingEntrant::find()->isOpenZUK($shareCg)) {
                        $userCg = UserCg::create($shareCg->id, $cathedra_id);
                        $this->repository->save($userCg);
                    }
                }
            }
        });
        return  $cg;
    }

    public function removeCg($id) {
        $cg = $this->repositoryCg->get($id);
        $this->transactionManager->wrap(function() use ($cg) {
            $userCg = $this->repository->get($cg->id);
            $statementCg = $this->statementCgRepository->getUserStatement($userCg->cg_id, $userCg->user_id);
            if($statementCg) {
                if ($statementCg->statement->files) {
                    throw new \DomainException('Для отмены выбора образовательной программы сначала удалите 
                    скан-копии соответствующего заявления!');
                }
                if($statementCg->statementConsentFiles)  {
                    throw new \DomainException('Для отмены выбора образовательной программы сначала удалите 
                    скан-копии соответствующего заявления о согласии на зачисление');
                }
                $statement = $this->statementRepository->get($statementCg->statement_id);
                if($statement->getStatementCg()->count() == 1) {
                    $this->statementRepository->remove($statement);
                }else {
                    $this->statementCgRepository->remove($statementCg);
                }
            }
            $this->repository->remove($userCg);
        });
        return $cg;
    }


}