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
        if(!$this->getStart()) {
            Yii::$app->session->setFlash("warning", $this->getMessage());
             Yii::$app->getResponse()->redirect(['site/index']);
             try {
                 Yii::$app->end();
             } catch (ExitException $e) {
             }
         }
        return (new UserNoEmail())->redirect();
    }

    public function getStart() {
        return strtotime("2024-12-18 00:00:01") < $this->currentDate() &&  strtotime("2025-02-05 18:00:00") > $this->currentDate();
    }

    private function currentDate()
    {
        //   \date_default_timezone_set('Europe/Moscow');
        return strtotime(\date("Y-m-d G:i:s"));
    }

    private function getMessage() {
        return date("n") > 6  && date("n") <= 12  ?  'Уважаемые студенты, приём документов в летний период переводов и восстановлений завершен! 
            Вы можете подать документы в зимний период с 18 декабря по 5 февраля.':
        'Прием заявок на переводы и восстановления в зимний период приема документов завершен.
        Прием документов осуществлялся с 18 декабря по 5 февраля.
        Следующий прием документов для переводов и восстановлений будут осуществляться в летний период приема документов 
             с 18 июня по 15 июля (на вакантные бюджетные места), по 20 августа (на места по договору об оказании платны образовательных услуг). 
             Контакты для связи с отделом переводов и восстановлений: 8(499)233-41-81 и otdel_vp@mpgu.su';
    }
}