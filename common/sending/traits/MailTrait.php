<?php

namespace common\sending\traits;

use common\auth\models\User;
use common\sending\helpers\SendingDeliveryStatusHelper;
use common\sending\helpers\SendingHelper;
use common\sending\models\DictSendingTemplate;
use common\sending\models\SendingDeliveryStatus;
use common\sending\repositories\SendingDeliveryStatusRepository;
use dictionary\models\DictSchools;
use olympic\models\OlimpicList;
use testing\repositories\TestGroupRepository;
use Yii;

trait MailTrait
{
    private $name = "Оргкомитет Олимпиады МПГУ";

    public function sendEmail(User $user, $configTemplate, $data, $subject)
    {
        return $this->sendDefault($user->email, $configTemplate, $data, $subject);
    }

    public function sendTeacherEmail(DictSchools $schools, $configTemplate, $data)
    {
        $subject = 'Запрос информации. ';
        return $this->sendDefault($schools->email, $configTemplate, $data, $subject);
    }

    protected function sendDefault($email, $configTemplate, $data, $subject)
    {
        $mailer = Yii::$app->olympicMailer;
        return $mailer
            ->mailer()
            ->compose($configTemplate, $data)
            ->setFrom([$mailer->getFromSender() => $this->name . ' robot'])
            ->setTo($email)
            ->setSubject($subject ." ". $this->name)
            ->send();
    }


    public function settingEmail(User $user, OlimpicList $olympic, $hash, $emailFrom, DictSendingTemplate $sendingTemplate, $typeSend) {
        $subject = SendingDeliveryStatusHelper::deliveryTypeName($typeSend).". ".$olympic->name;
        return $this->getDataEmail($olympic)
            ->mailer()
            ->compose()
            ->setFrom([$emailFrom =>  $this->name . ' robot']) //@TODO Надо что-то написать нормальное
            ->setTo($user->email)
            ->setTextBody(SendingHelper::textOlympicEmail($user, $olympic, $hash, SendingHelper::TYPE_TEXT, $sendingTemplate, $typeSend))
            ->setHtmlBody(SendingHelper::textOlympicEmail($user, $olympic, $hash, SendingHelper::TYPE_HTML, $sendingTemplate, $typeSend))
            ->setSubject($subject);
    }

    public function getDataEmail(OlimpicList $olympic) {
        $mailer = \Yii::$app->olympicMailer;
        $mailer->olympic = $olympic->id;
        return $mailer;
    }

    public function send(User $user,
                         OlimpicList $olympic,
                         SendingDeliveryStatusRepository $repository,
                         $type,
                         $type_send,
                         $sending_id,
                         DictSendingTemplate $sendingTemplate) {
        $exit = $repository->getExits($user->id, $type, $olympic->id, $type_send);

        if (!$exit && $user->email) {
            try {
                $emailFrom = $this->getDataEmail($olympic)->getFromSender();
                $hash = \Yii::$app->security->generateRandomString() . '_' . time();
                $this->settingEmail($user, $olympic, $hash, $emailFrom, $sendingTemplate, $type_send)->send();
                $delivery = SendingDeliveryStatus::create( $sending_id, $user->id,
                    $hash, $type, $type_send, $olympic->id, $emailFrom);
                $repository->save($delivery);
            } catch (\Swift_TransportException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
    }
}