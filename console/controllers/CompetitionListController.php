<?php
namespace console\controllers;

use modules\dictionary\components\RegisterCompetitiveListComponent;
use modules\dictionary\models\RegisterCompetitionList;
use modules\exam\helpers\ExamHelper;
use yii\console\Controller;

class CompetitionListController extends Controller
{
    public function actionIndex()
    {
        \set_time_limit(1800); // 30 мин.
        $handler = new RegisterCompetitiveListComponent(RegisterCompetitionList::TYPE_AUTO);
       $handler->handle();
       exec('/usr/local/bin/php ' . \Yii::getAlias('@app') . '/yii queue/run > /dev/null &');
       echo "окей";
    }

    public function actionSendMail()
    {
        echo RegisterCompetitionList::find()->andWhere(['status'=>3, 'type_update'=> RegisterCompetitionList::TYPE_AUTO])->count();
    }
}