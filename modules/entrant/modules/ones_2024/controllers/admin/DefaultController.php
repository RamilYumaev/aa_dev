<?php
namespace modules\entrant\modules\ones_2024\controllers\admin;

use modules\entrant\modules\ones_2024\job\ImportEntrantAppJob;
use modules\entrant\modules\ones_2024\job\ImportEntrantOneSJob;
use modules\entrant\modules\ones_2024\job\ImportEntrantPriorityAppJob;
use modules\entrant\modules\ones_2024\job\ImportOriginalSsJob;
use modules\entrant\modules\ones_2024\model\FileSS;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;

class DefaultController extends Controller
{
    const PATH   = '@modules/entrant/modules/ones_2024/views/en.xlsx';
    const PATH_   = '@modules/entrant/modules/ones_2024/views/update.xlsx';
    const PATH__   = '@modules/entrant/modules/ones_2024/views/1s.xlsx';
    const PATH___   = '@modules/entrant/modules/ones_2024/views/orig.xlsx';
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
    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider(['query' => FileSS::find()->orderBy(['created_at' => SORT_DESC])]);
        return $this->render('index',['dataProvider' => $dataProvider]);
    }

    /**
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FileSS();
        $data = Yii::$app->request->post();
        if($model->load($data) && $model->validate()) {
            $model->save();
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    public function actionEnHandle()
    {
        $queue = Yii::$app->queue;
        $queue->ttr(20000);
        $message = 'Задание отправлено в очередь';
        $queue->push(new ImportEntrantAppJob(['model'=>null, 'path'=> self::PATH]));

        Yii::$app->session->setFlash("info", $message);
        return  $this->redirect('index');
    }

    public function actionOrigHandle()
    {
        $queue = Yii::$app->queue;
        $queue->ttr(20000);
        $message = 'Задание отправлено в очередь';
        $queue->push(new ImportOriginalSsJob(['model'=>null, 'path'=> self::PATH___]));

        Yii::$app->session->setFlash("info", $message);
        return  $this->redirect('index');
    }


    public function actionEnHandleOneS()
    {
        $queue = Yii::$app->queue;
        $queue->ttr(20000);
        $message = 'Задание отправлено в очередь';
        $queue->push(new ImportEntrantOneSJob(['model'=>null, 'path'=> self::PATH__]));

        Yii::$app->session->setFlash("info", $message);
        return  $this->redirect('index');
    }

    public function actionEnUpdateHandle()
    {
        $queue = Yii::$app->queue;
        $queue->ttr(20000);
        $message = 'Задание отправлено в очередь';
        $queue->push(new ImportEntrantPriorityAppJob(['model'=>null, 'path'=> self::PATH_]));

        Yii::$app->session->setFlash("info", $message);
        return  $this->redirect('index');
    }
}
