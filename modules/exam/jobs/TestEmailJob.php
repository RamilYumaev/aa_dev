<?php


namespace modules\exam\jobs;
use Yii;
use yii\base\BaseObject;

class TestEmailJob extends BaseObject implements \yii\queue\JobInterface
{

    public function execute($queue)
    {
        $mailer = Yii::$app->selectionCommitteeMailer;
        return $mailer
            ->mailer()
            ->compose()
            ->setFrom([$mailer->getFromSender() => $mailer->getSubject() . ' robot'])
            ->setTo('markpdd13@list.ru')
            ->setSubject("Тест" ." ". $mailer->getSubject())
            ->send();
    }
}