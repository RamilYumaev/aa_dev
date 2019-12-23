<?php

namespace common\sending\traits;

use common\auth\models\User;
use common\sending\helpers\SendingHelper;
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

    public function settingEmail(User $user, OlimpicList $olympic, $hash) {
        $mailer = \Yii::$app->olympicMailer;
        $mailer->olympic = $olympic->id;
        return $mailer
            ->mailer()
            ->compose()
            ->setFrom([$mailer->getFromSender() => \Yii::$app->name . ' robot'])
            ->setTo($user->email)
            ->setTextBody(SendingHelper::textEmail($user, $olympic, $hash, SendingHelper::TYPE_TEXT))
            ->setHtmlBody(SendingHelper::textEmail($user, $olympic, $hash, SendingHelper::TYPE_HTML))
            ->setSubject('Приглашение ' . \Yii::$app->name);
    }

}