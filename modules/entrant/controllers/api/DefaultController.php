<?php
namespace modules\entrant\controllers\api;

use modules\entrant\helpers\DataExportHelper;
use Yii;
use yii\base\InvalidConfigException;
use yii\rest\Controller;


class DefaultController extends Controller
{
   
    public function actionIndex()
    {
        return [
            'version' => '1.0.0',
        ];
    }

    public function actionDataExport()
    {
        try {
           return Yii::$app->request->getBodyParams();
        } catch (InvalidConfigException $e) {
        }
    }

    public function verbs()
    {
        return [
            'index' => ["GET"],
            'dataExport' => ["POST"],
      ];
   }
}
