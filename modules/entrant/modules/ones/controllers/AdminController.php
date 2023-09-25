<?php

namespace modules\entrant\modules\ones\controllers;

use modules\entrant\modules\ones\job\AlternateHandle;
use modules\entrant\modules\ones\job\FinalHandler;
use modules\entrant\modules\ones\job\HandleList;
use modules\entrant\modules\ones\job\HandleScopePassList;
use modules\entrant\modules\ones\job\ImportCgJob;
use modules\entrant\modules\ones\job\MarkHandler;
use modules\entrant\modules\ones\model\CompetitiveGroupOnes;
use modules\entrant\modules\ones\model\CompetitiveList;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class AdminController extends Controller
{
    const PATH   = '@modules/entrant/modules/ones/views/cg.xlsx';
    public function behaviors(): array
    {
        return [
            [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['dev'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCgHandle()
    {
        Yii::$app->queue->push(new ImportCgJob(['path'=> self::PATH]));
        $message = 'Задание "Конкурсные группы" отправлено в очередь';
        Yii::$app->session->setFlash("info", $message);
        return  $this->redirect('index');
    }

    public function actionListHandle()
    {
        Yii::$app->queue->push(new HandleList());
        $message = 'Задание "Провести конкурс" отправлено в очередь';
        Yii::$app->session->setFlash("info", $message);
        return  $this->redirect('index');
    }

    public function actionAlternateHandle()
    {
        Yii::$app->queue->push(new AlternateHandle());
        $message = 'Задание "Провести конкурс (альтернатіва)" отправлено в очередь';
        Yii::$app->session->setFlash("info", $message);
        return  $this->redirect('index');
    }

    public function actionMarkHandle()
    {
        Yii::$app->queue->push(new MarkHandler());
        $message = 'Задание "Провести конкурс (альтернатіва)" отправлено в очередь';
        Yii::$app->session->setFlash("info", $message);
        return  $this->redirect('index');
    }

    public function actionFinalHandle($level)
    {
        Yii::$app->queue->push(new FinalHandler(['eduLevel' => $level]));
        $message = 'Задание "Провести конкурс (альтернатива)" '.$level.' отправлено в очередь';
        Yii::$app->session->setFlash("info", $message);
        return  $this->redirect('index');
    }

    public function actionClear($level){
        $cgs = CompetitiveGroupOnes::find()->andWhere(['education_level'=>$level])->select('id')->column();
        $message = 'Не найдены кг.';
        if($cgs) {
            CompetitiveGroupOnes::updateAll(['status'=> CompetitiveGroupOnes::STATUS_NEW], ['id' => $cgs]);
            CompetitiveList::updateAll(['status'=> CompetitiveList::STATUS_NEW], ['cg_id'=> $cgs]);
            $message = 'Конкурс обнулен. '.$level;
        }
        Yii::$app->session->setFlash("info", $message);
        return  $this->redirect('index');
    }

    public function actionSemiHandle()
    {
        Yii::$app->queue->push(new HandleScopePassList());
        $message = 'Задание "Найти поупрходные баллы" отправлено в очередь';
        Yii::$app->session->setFlash("info", $message);
        return  $this->redirect('index');
    }
}
