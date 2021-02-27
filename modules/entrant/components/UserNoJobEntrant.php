<?php


namespace modules\entrant\components;
use Yii;

class UserNoJobEntrant
{
    public function redirect() {
        if (!Yii::$app->user->getIsGuest() && Yii::$app->user->identity->getId()) {
            /* @var $job  \modules\dictionary\models\JobEntrant */
            $job = Yii::$app->user->identity->jobEntrant();
            if (!$job) {
                return Yii::$app->getResponse()->redirect(['profile/entrant-job']);
            }
            if (is_null(Yii::$app->user->identity->getEmail())  || !Yii::$app->user->identity->isActive()) {
                return Yii::$app->getResponse()->redirect(['sign-up/user-edit']);
            }
        }
        return true;
    }
}