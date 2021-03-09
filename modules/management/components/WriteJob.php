<?php


namespace modules\management\components;

use common\auth\models\User;
use Mpdf\Tag\B;
use olympic\models\auth\Profiles;
use Yii;
use yii\base\BaseObject;
use yii\web\NotFoundHttpException;

class WriteJob extends BaseObject implements \yii\queue\JobInterface
{

    public $userId;
    public $url;

    public function execute($queue)
    {
        $user = Profiles::findOne($this->userId);

        $mailer = Yii::$app->olympicMailer;
        $mailer
            ->mailer()
            ->compose(
                ['html' => 'task/newTask-html', 'text' => 'task/newTask-text'],
                ['profile' => $user, 'text'=> 't']
            )->setFrom([$mailer->getFromSender() => Yii::$app->name . ' robot'])
            ->setTo('markpdd13@list.ru')
            ->setSubject('Сброс пароля ' . Yii::$app->name)
            ->send();
    }
}