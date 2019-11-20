<?php


namespace frontend\components;
use Yii;

class UserNoEmail
{
    public function redirect() {
        if (!Yii::$app->user->getIsGuest() && Yii::$app->user->identity->getId()) {
            if (is_null(Yii::$app->user->identity->getEmail()) ) {
                return Yii::$app->getResponse()->redirect(['/auth/signup/add-email']);
            }
        }
        return true;
    }
}