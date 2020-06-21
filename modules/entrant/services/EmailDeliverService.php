<?php


namespace modules\entrant\services;

use olympic\models\auth\Profiles;
use olympic\repositories\auth\ProfileRepository;

class EmailDeliverService
{
    public $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository= $profileRepository;
    }

    public function errorSend($email_id, $user_id)
    {
        $profile = $this->profileRepository->getUser($user_id);
        try {
            $this->sendEmailError($email_id, $profile)->send();
            \Yii::$app->session->setFlash('success', 'Отправлено.');
        } catch (\Swift_TransportException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    private function sendEmailError($emailId, Profiles $profile)
    {
        $mailer = \Yii::$app->selectionCommitteeMailer;
        $mailer->idSettingEmail = $emailId;

        $configTemplate =  ['html' => 'errorEntrant-html', 'text' => 'errorEntrant-text'];
        $configData = ['profile' => $profile];
        return $mailer
            ->mailer()
            ->compose($configTemplate, $configData)
            ->setFrom([$mailer->getFromSender() => 'МПГУ робот'])
            ->setTo($profile->user->email)

            ->setSubject('МПГУ робот. Обнаружены ошибки');
    }

}