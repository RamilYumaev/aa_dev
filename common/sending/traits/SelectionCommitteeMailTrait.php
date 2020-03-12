<?php

namespace common\sending\traits;

use common\auth\models\User;
use common\sending\helpers\SendingDeliveryStatusHelper;
use common\sending\helpers\SendingHelper;
use common\sending\models\DictSendingTemplate;
use common\sending\models\SendingDeliveryStatus;
use common\sending\repositories\SendingDeliveryStatusRepository;
use dod\models\DateDod;
use Yii;

trait SelectionCommitteeMailTrait
{
    public function sendEmail(User $user, $configTemplate, $data, $subject)
    {
        $mailer = $this->defaultMail();
        return $mailer
            ->mailer()
            ->compose($configTemplate, $data)
            ->setFrom([$mailer->getFromSender() => $mailer->getSubject() . ' robot'])
            ->setTo($user->email)
            ->setSubject($subject ." ". $mailer->getSubject())
            ->send();
    }

    protected function  defaultMail ()
    {
        return Yii::$app->selectionCommitteeMailer;
    }

    public function settingEmail(User $user, DateDod $dod, $hash, $emailFrom, DictSendingTemplate $sendingTemplate, $typeSend) {
        $mailer = $this->defaultMail();
        $subject = SendingDeliveryStatusHelper::deliveryTypeName($typeSend).". ".$mailer->getSubject();
        return $mailer
            ->mailer()
            ->compose()
            ->setFrom([$emailFrom =>  $mailer->getSubject() . ' robot']) //@TODO Надо что-то написать нормальное
            ->setTo($user->email)
            ->setTextBody(SendingHelper::textDodEmail($user, $dod, $hash, SendingHelper::TYPE_TEXT, $sendingTemplate, $typeSend))
            ->setHtmlBody(SendingHelper::textDodEmail($user, $dod, $hash, SendingHelper::TYPE_HTML, $sendingTemplate, $typeSend))
            ->setSubject($subject);
    }

    public function send(User $user,
                         DateDod $dod,
                         SendingDeliveryStatusRepository $repository,
                         $type,
                         $type_send,
                         $sending_id,
                         DictSendingTemplate $sendingTemplate) {
        $exit = $repository->getExits($user->id, $type, $dod->id, $type_send);

        if (!$exit && $user->email) {
            try {
                $emailFrom = $this->defaultMail()->getFromSender();
                $hash = \Yii::$app->security->generateRandomString() . '_' . time();
                $this->settingEmail($user, $dod, $hash, $emailFrom, $sendingTemplate, $type_send)->send();
                $delivery = SendingDeliveryStatus::create( $sending_id, $user->id,
                    $hash, $type, $type_send, $dod->id, $emailFrom);
                $repository->save($delivery);
            } catch (\Swift_TransportException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
                return;
            }
        }
    }
}