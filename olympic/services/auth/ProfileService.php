<?php

namespace olympic\services\auth;

use olympic\forms\auth\ProfileEditForm;
use olympic\repositories\auth\ProfileRepository;

class ProfileService
{
    private $profile;

    public function __construct(ProfileRepository $profile)
    {
        $this->profile = $profile;
    }

    public function edit(ProfileEditForm $form)
    {
        $profile = $this->profile->getUserId();
        $profile->edit($form);
        $this->profile->save($profile);
    }

}