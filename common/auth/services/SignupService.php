<?php


namespace common\auth\services;

use common\auth\forms\UserEmailForm;
use common\sending\helpers\DictSendingTemplateHelper;
use common\sending\helpers\SendingDeliveryStatusHelper;
use common\sending\models\SendingDeliveryStatus;
use common\sending\repositories\SendingDeliveryStatusRepository;
use common\sending\traits\MailTrait;
use olympic\models\auth\Profiles;
use olympic\models\OlimpicList;
use olympic\repositories\auth\ProfileRepository;
use olympic\repositories\OlimpicListRepository;
use Yii;
use common\auth\forms\SignupForm;
use common\auth\models\User;
use common\auth\repositories\UserRepository;
use common\transactions\TransactionManager;
use yii\base\InvalidArgumentException;

class SignupService
{
    private $users;
    private $transaction;
    private $profileRepository;
    private $olimpicListRepository;
    private $deliveryStatusRepository;

    use MailTrait;

    public function __construct(
        UserRepository $users,
        TransactionManager $transaction,
        ProfileRepository $profileRepository,
        OlimpicListRepository $olimpicListRepository,
        SendingDeliveryStatusRepository $deliveryStatusRepository
    )
    {
        $this->users = $users;
        $this->transaction = $transaction;
        $this->profileRepository = $profileRepository;
        $this->olimpicListRepository = $olimpicListRepository;
        $this->deliveryStatusRepository = $deliveryStatusRepository;
    }

    public function signup(SignupForm $form): void
    {
        $this->transaction->wrap(function () use ($form) {
            $user = $this->newUser($form);
            $this->users->save($user);

            $profile = $this->newProfile($user->id);
            $this->profileRepository->save($profile);

            $configTemplate =  ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'];
            $configData = ['user' => $user];

            $this->sendEmail($user, $configTemplate, $configData);
        });
    }

    public function newUser(SignupForm $form): User
    {
        $user = User::requestSignup($form);
        return $user;
    }

    public function newProfile($user_id): Profiles
    {
        $profile = Profiles::createDefault($user_id);
        return $profile;
    }

    public function addEmail(UserEmailForm $form)
    {
        $user = $this->users->get(Yii::$app->user->identity->getId());
        $user->addEmail($form);
        $this->users->save($user);
    }

    public function confirm($token)
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Verify email token cannot be blank.');
        }
        $user = $this->users->getByVerificationToken($token);
        $user->confirmSignup();
        $this->users->save($user);
        return $user;
    }

    public function confirmOlympic($token, $olympic) {
        if (($sendingTemplate = DictSendingTemplateHelper::dictTemplate(SendingDeliveryStatusHelper::TYPE_OLYMPIC,
                SendingDeliveryStatusHelper::TYPE_SEND_INVITATION)) == null) {
            throw new \DomainException( 'Нет шаблона рассылки. Обратитесь к админстратору.');
        }
        $user = $this->confirm($token);
        $olympic = $this->olimpicListRepository->get($olympic);
        if ($olympic->isFormOfPassageInternal()) {
            $this->send($user, $olympic, $this->deliveryStatusRepository,
                SendingDeliveryStatusHelper::TYPE_OLYMPIC,
                SendingDeliveryStatusHelper::TYPE_SEND_INVITATION, null, $sendingTemplate);
        }
    }

}