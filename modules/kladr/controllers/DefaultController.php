<?php

namespace modules\kladr\controllers;

use modules\kladr\models\Kladr;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($widgetId)
    {
        return $this->renderAjax('_list', ['widgetId' => $widgetId]);
    }

    public function actionGetDistricts($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['items' => self::prepareItems(Kladr::getDistricts($id))];
    }

    public function actionGetCities($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['items' => self::prepareItems(Kladr::getCities($id))];
    }

    public function actionGetVillages($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['items' => self::prepareItems(Kladr::getVillages($id))];
    }

    public function actionGetStreets($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['items' => self::prepareItems(Kladr::getStreets($id))];
    }

    public function actionGetHouses($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['items' => self::prepareItems(Kladr::getHouses($id))];
    }

    public function actionGetPostcode($house)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['postcode' => Kladr::getPostcode($house)];
    }

    /**
     * Формируем структуру необходимую для представления, для Select2.
     * @param array $data
     * @return array
     */
    protected static function prepareItems($data)
    {
        $items = [];
        foreach ($data as $key => $value) {
            $items[] = ['id' => $key, 'text' => $value];
        }

        return $items;
    }
}
