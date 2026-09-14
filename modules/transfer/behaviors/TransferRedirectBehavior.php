<?php

namespace modules\transfer\behaviors;

use modules\transfer\models\TransferMpgu;
use modules\transfer\models\TransferSetting;
use Mpdf\Tag\Tr;
use yii\base\Behavior;
use yii\base\ExitException;
use yii\db\Expression;
use yii\web\Controller;
use Yii;


class TransferRedirectBehavior  extends Behavior
{
    public $ids = [];
    /**
     * @var Controller
     */
    public $owner;

    public function events()
    {
        return [
           Controller::EVENT_BEFORE_ACTION=> 'beforeAction',
        ];
    }

    public function beforeAction($event)
    {
        $model = $this->transfer();
        if ((!$model)
            && in_array($this->owner->action->id, $this->ids)) {
            Yii::$app->session->setFlash("warning", 'Страница недоступна');
            Yii::$app->getResponse()->redirect(['transfer/default/fix']);
            try {
                Yii::$app->end();
            } catch (ExitException $e) {
            }
        }
    }

    private function transfer()
    {
        return TransferMpgu::findOne($this->userWhere());
    }

    public function isRule(TransferMpgu $transferMpgu) {
        return TransferSetting::find()->andWhere(['>=', 'date_start', new Expression('CURDATE()')])
        ->andWhere(['<', 'date_end', date('Y-m-d H:i:s')])->andWhere(['like', 'citizenship', $transferMpgu->citizenship_id])->exists();
    }


    private function userWhere() {
        return ['user_id' => Yii::$app->user->identity->getId()];
    }
}