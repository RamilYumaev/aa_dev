<?php

namespace modules\transfer;

use frontend\components\UserNoEmail;
use Yii;
use yii\base\ExitException;
use yii\base\Module;
use yii\filters\AccessControl;

class FrontendTransfer extends Module
{
    public  $controllerNamespace = 'modules\transfer\controllers\frontend';

    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $url = ['no', 'yes', 'get', 'create', 'update-receipt', 'form',
            'get-receipt', 'message', "add-receipt", 'delete',
            'add', 'upload', 'update', 'agreement-contract',  'contract-send'];
        if(in_array(Yii::$app->controller->action->id, $url)) {
            return true;
        }
        if($this->getEnd()) {
            Yii::$app->session->setFlash("warning", 'Уважаемые студенты, приём документов в летний период переводов и восстановлений завершен! 
            Вы можете подать документы в зимний период с 18 декабря по 5 февраля.');
             Yii::$app->getResponse()->redirect(['site/index']);
             try {
                 Yii::$app->end();
             } catch (ExitException $e) {
             }
         }
        return (new UserNoEmail())->redirect();
    }

    public function getEnd() {
        return strtotime("2022-08-20 15:00:00") < $this->currentDate();
    }

    private function currentDate()
    {
        //   \date_default_timezone_set('Europe/Moscow');
        return strtotime(\date("Y-m-d G:i:s"));
    }

}