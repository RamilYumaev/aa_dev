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
         if($this->getEnd()) {
             Yii::$app->session->setFlash("warning", 'Прием заявок на переводы и восстановления в летний период приема документов завершен. Прием документов осуществлялся с 18 июня по 15 июля (на вакантные бюджетные места), по 20 августа (на места по договору об оказании платны образовательных услуг). Следующий прием документов для переводов и восстановлений будут осуществляться в зимний период приема документов (с 18 декабря по 5 февраля).
Контакты для связи с отделом переводов и восстановлений: 8(499)233-41-81 и otdel_vp@mpgu.su');
             Yii::$app->getResponse()->redirect(['site/index']);
             try {
                 Yii::$app->end();
             } catch (ExitException $e) {
             }
         }
        return (new UserNoEmail())->redirect();
    }

    public function getEnd() {
        return strtotime("2021-08-20 17:00:00") < $this->currentDate();
    }

    private function currentDate()
    {
        //   \date_default_timezone_set('Europe/Moscow');
        return strtotime(\date("Y-m-d G:i:s"));
    }

}