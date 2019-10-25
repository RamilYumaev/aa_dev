<?php


namespace olympic\services\auth;


use olympic\forms\auth\ProfileForm;
use olympic\models\auth\Profiles;
use olympic\readRepositories\UserReadRepository;
use olympic\repositories\auth\ProfileRepository;

class ProfileService
{
    private $user;
    private $profile;

    public function __construct(ProfileRepository $profile, UserReadRepository $user)
    {
        $this->profile = $profile;
        $this->user = $user;
    }

    public function createOrEdit(ProfileForm $form) {

        if(!$this->profile->getUserId())  {
          $profile = $this->create($form);
        }
        else {
          $profile = $this->edit($form);
        }
        $this->profile->save($profile);
    }

    public function create(ProfileForm $form) {
        $profile = Profiles::create($form);
        return $profile;
    }

    public function edit(ProfileForm $form) {
        $profile =  $this->profile->getUserId();
        $profile->edit($form);
        return $profile;
    }

}