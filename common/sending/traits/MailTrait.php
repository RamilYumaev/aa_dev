<?php

namespace common\sending\traits;

use common\auth\models\User;
use common\sending\helpers\DictSendingTemplateHelper;
use common\sending\helpers\SendingDeliveryStatusHelper;
use common\sending\helpers\SendingHelper;
use common\sending\models\DictSendingTemplate;
use common\sending\models\SendingDeliveryStatus;
use common\sending\repositories\SendingDeliveryStatusRepository;
use olympic\models\OlimpicList;
use Yii;

trait MailTrait
{
    public function sendEmail(User $user, $configTemplate, $data)
    {
        return Yii::$app
            ->mailer
            ->compose($configTemplate, $data)
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($user->email)
            ->setSubject('Аккуант зарегистрирован!' . Yii::$app->name)
            ->send();
    }

    public function settingEmail(User $user, OlimpicList $olympic, $hash, $emailFrom, DictSendingTemplate $sendingTemplate, $typeSend) {
        $subject = SendingDeliveryStatusHelper::deliveryTypeName($typeSend).". ".$olympic->name;
        return $this->getDataEmail($olympic)
            ->mailer()
            ->compose()
            ->setFrom([$emailFrom => \Yii::$app->name . ' robot']) //@TODO Надо что-то написать нормальное
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