<?php

namespace olympic\jobs;
use common\sending\traits\MailTrait;
use olympic\models\UserOlimpiads;
use yii\base\BaseObject;

class TestEmailJob extends BaseObject implements \yii\queue\JobInterface
{
    use MailTrait;
    public $olympicId;
    public function execute($queue)
    {
        $model = UserOlimpiads::find()->where(['olympiads_id' => $this->olympicId])->andWhere(['information' => null]);
        if($model->count()) {
            /** @var UserOlimpiads $item */
            foreach ($model->all() as $item) {
                $configTemplate = ['html' => 'olympic/emailSubject-html', 'text' => 'olympic/emailSubject-text'];
                $configData = ['id' => $this->olympicId];
                $this->sendEmail($item->user, $configTemplate, $configData, "Информация.");
            }
        }
    }
}