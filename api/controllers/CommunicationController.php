<?php


namespace api\controllers;

use yii\base\Exception;
use yii\base\InvalidArgumentException;
use yii\helpers\Json;
use yii\rest\Controller;
use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class CommunicationController extends Controller
{
    const ACTION_ADD = 1;
    const ACTION_DEL = 2;
    const ACTION_UPDATE = 3;

    public function verbs()
    {
        return [
            'dictionary' => ['POST'],'index' => ["GET"],
        ];
    }


    public function actionIndex()
    {
        return [
            'version' => '1.0.0',
        ];
    }

    public function actionDictionary()
    {
        $name = Yii::$app->request->post('name');
        $action = Yii::$app->request->post('action');
        $token = Yii::$app->request->post('token');
        $data = Yii::$app->request->post('data');

        if (!$name || !$action || !$token || !$data) {
            throw new InvalidArgumentException();
        }
        if (!self::checkToken($name, $token)) {
            throw new ForbiddenHttpException();
        }

        /** @var yii\db\ActiveRecord $modelName */
        $modelName = 'dictionary\models\ais\\' . $name;
        if (!class_exists($modelName)) {
           throw new NotFoundHttpException('The model '.$name.' does not exist.');
        }

        if (!method_exists($modelName,'attributeAis')) {
            throw new NotFoundHttpException('The method attributeAis does not exist.');
        }
            $data = Json::decode($data);
            if ($action == self::ACTION_ADD) {
                /** @var yii\db\ActiveRecord $model */
                $model = new $modelName();
                $model->setAttributes($model->dataAis($data), false);
                if (!$model->save()) {
                    throw new Exception(print_r($model->errors + $data, true));
                }
                return;
            }
            if ($action == self::ACTION_UPDATE) {
                if (!isset($data['id'])) {
                    throw new InvalidArgumentException();
                }

                $model = $modelName::findOne($data['id']);
                if ($model === null) {
                    /** @var yii\db\ActiveRecord $model */
                    $model = new $modelName();
                    $model->setAttributes($model->dataAis($data), false);
                    if (!$model->save()) {
                        throw new Exception(print_r($model->errors + $data, true));
                    }
                    return;
                }

                $model->setAttributes($model->dataAis($data), false);
                if (!$model->save()) {
                    throw new Exception(print_r($model->errors + $data, true));
                }
                return;
            }
            if ($action == self::ACTION_DEL) {
                if (!isset($data['id'])) {
                    throw new InvalidArgumentException();
                }

                $model = $modelName::findOne($data['id']);
                if (($model === null || !$model->delete())) {
                    throw new Exception(print_r($data, true));
                }
                return;
            }

            throw new InvalidArgumentException();

    }

    protected static function checkToken($id, $token)
    {
        return md5($id . date('Y.m.d') . Yii::$app->params['incomingCommunicationKey']) === $token;
    }
}