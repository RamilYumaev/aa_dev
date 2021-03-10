<?php

namespace modules\management\controllers\user;

use modules\management\models\ManagementUser;
use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $user = Yii::$app->user->identity->getId();
        $management = ManagementUser::find();
        $md = clone $management;
        $isAssistant = $management->user($user)->assistant()->exists();
        $isDirector = $md->userDirector($user)->exists();
        $isCreateTask = $isAssistant || $isDirector;
        return $this->render('index', ['isCreateTask' => $isCreateTask]);
    }

}
