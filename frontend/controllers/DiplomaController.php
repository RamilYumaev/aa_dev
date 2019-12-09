<?php
namespace frontend\controllers;

use olympic\models\Diploma;
use olympic\readRepositories\OlimpicReadRepository;
use yii\web\Controller;
use yii\web\HttpException;


class DiplomaController extends Controller
{
    public $layout = 'print';
    private $repository;

    public function __construct($id, $module, OlimpicReadRepository $repository, $config = [])

    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
    }

    public function actionIndex($id, $hash = null)
    {
        $this->layout = '@app/views/layouts/print.php';
        $model =  Diploma::findOne($id);

        if (!$model) {
            throw new HttpException('404', 'Такой страницы не существует');
        }
        $olympic = $this->repository->findOldOlympic($model->olimpic_id);
        if (!$olympic) {
            throw new HttpException('404', 'Такой страницы не существует');
        }
        //        if ($hash !== null) {
//            $readStatus = SendingDeliveryStatus::find()->andWhere(['hash' => $hash])->limit(1)->one();
//            if ($readStatus === null) {
//                throw new HttpException('404', 'Такой страницы не существует');
//            }
//
//            if ($readStatus->status_id ?? null !== SendingDeliveryStatus::STATUS_READ) {
//                $readStatus->updateAttributes(['status_id' => SendingDeliveryStatus::STATUS_READ]);
//            }
//        }


        return $this->render('index', [
            'model' => $model,
            'olympic' => $olympic
        ]);
    }
}