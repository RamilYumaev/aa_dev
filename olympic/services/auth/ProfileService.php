<?php

namespace olympic\services\auth;

use modules\entrant\repositories\StatementRepository;
use olympic\forms\auth\ProfileEditForm;

use olympic\repositories\auth\ProfileRepository;
use olympic\repositories\UserOlimpiadsRepository;


class ProfileService
{
    private $profile;
    private $statementRepository;
    private $userOlimpiadsRepository;

    public function __construct(ProfileRepository $profile, UserOlimpiadsRepository $userOlimpiadsRepository,
                                StatementRepository $statementRepository)
    {
        $this->profile = $profile;
        $this->userOlimpiadsRepository = $userOlimpiadsRepository;
        $this->statementRepository = $statementRepository;
    }

    public function edit(ProfileEditForm $form)
    {
        $profile = $this->profile->getUserId();
        $profile->edit($form);
        if(!$this->userOlimpiadsRepository->getUserExits($profile->user_id) ) {
            if(!$this->statementRepository->getStatementStatusNoDraft($profile->user_id) ) {
                $profile->detachBehavior("moderation");
            }
        }


        $this->profile->save($profile);
    }

}