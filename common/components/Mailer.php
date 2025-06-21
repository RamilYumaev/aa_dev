<?php


namespace common\components;


use common\auth\models\SettingEmail;
use olympic\models\OlimpicList;
use olympic\models\Olympic;
use yii\base\Component;
use Yii;

class Mailer extends Component
{
    public $defaultHost;
    public $defaultPort;
    public $defaultUsername;
    public $defaultPassword;
    public $defaultEncryption;
    public $olympic = null;
    public $idSettingEmail = null;
    public $subject;

    public function mailer () {
        return Yii::createObject([
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => $this->getHost(),
                'username' => $this->getUsername(),
                'password' => $this->getPassword(),
                'port' => $this->getPort(),
                'encryption' => $this->getEncryption(),
                'streamOptions' => [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true,
                    ],
                ],

            ],
        ]);
    }

    private function dataOlympicManager() {
        if ($this->olympic && (($olympic = OlimpicList::findOne($this->olympic)) !== null)) {
            return Olympic::findOne($olympic->olimpic_id)->managerId;
        }
        return null;
    }

    private function dataEmailManager() {
        if($this->dataOlympicManager()) {
            return SettingEmail::findOne(['user_id'=> $this->dataOlympicManager(), 'status'=> SettingEmail::ACTIVATE]) ?? null;
        } else if ($this->idSettingEmail) {
            return SettingEmail::findOne($this->idSettingEmail);
        }
        return null;
    }

    private function getHost() {
        return $this->dataEmailManager() ? $this->dataEmailManager()->host : $this->defaultHost;
    }

    private function getUsername() {
        return $this->dataEmailManager() ? $this->dataEmailManager()->username : $this->defaultUsername;
    }

    private function getPassword() {
        return $this->dataEmailManager() ? $this->dataEmailManager()->password : $this->defaultPassword;
    }

    private function getPort() {
        return $this->dataEmailManager() ? $this->dataEmailManager()->port : $this->defaultPort;
    }

    private function getEncryption() {
        return $this->dataEmailManager() ? $this->dataEmailManager()->encryption : $this->defaultEncryption;
    }

    public function getFromSender()
    {
        return $this->getUsername();
    }

    public function getSubject() {
        return $this->subject;
    }


}