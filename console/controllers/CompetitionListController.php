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
       exec('/usr/local/bin/php /usr/home/sdotest/www/yii queue/run');
       echo "окей";

        /** @var \yii\caching\FileCache $competitionListCache */
        $competitionListCache = \Yii::$app->competitionListCache;
        $competitionListCache->flush();
    }

    public function actionSendMail()
    {
        echo RegisterCompetitionList::find()->andWhere(['status'=>3, 'type_update'=> RegisterCompetitionList::TYPE_AUTO])->count();
    }
}