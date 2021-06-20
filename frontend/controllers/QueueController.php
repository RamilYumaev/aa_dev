<?php
namespace frontend\controllers;

use modules\entrant\models\Talons;
use yii\web\Controller;
use yii\web\Response;


class QueueController extends Controller
{
    public  $layout = 'queue';

    public function actionIndex()
    {
        return $this->render('index', [
        ]);
    }

    public function actionTablo()
    {

        $queues = [];
        $queue = [];

        $talons = Talons::find()
            ->andWhere(['date'=> date("Y-m-d")])
            ->andWhere(['status'=>Talons::STATUS_WAITING])->limit(5)->all();

        foreach ($talons as $talon){
            $queue['talon'] = $talon->name;
            $queue['number_of_table'] = $talon->num_of_table;
            $queue['status'] = $talon->status;
            $queues[] = $queue;
        }


//        $queues = [
//            ['talon'=>'Пушкин А.С.', 'number_of_table'=>'13', 'status'=>0],
//            ['talon'=>'Лермонтов М.Ю', 'number_of_table'=>'1', 'status'=>0],
//            ['talon'=>'Салтыков-Щедрин М.Е.', 'number_of_table'=>'13', 'status'=>0],
//            ['talon'=>'M11', 'number_of_table'=>'1', 'status'=>0],
//            ['talon'=>'M10', 'number_of_table'=>'13', 'status'=>0],
//        ];
        return $this->render('tablo', [
            'queues' => $queues,
        ]);
    }

    public function actionProfi()
    {
        return $this->render('index', [
        ]);
    }

    public function actionJson()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        return [
            ['talon'=>'M10', 'number_of_table'=>'13', 'status'=>0],
            ['talon'=>'M11', 'number_of_table'=>'1', 'status'=>0],
        ];
    }


    public function actionLocal()
    {
        return $this->render('local');
    }

}