<?php
namespace modules\entrant\controllers\api;

use modules\entrant\helpers\DataExportHelper;
use modules\entrant\jobs\api\CseJob;
use modules\entrant\services\UserDisciplineService;
use Yii;
use yii\rest\Controller;


class DefaultController extends Controller
{
    private $service;

    public function __construct($id, $module, UserDisciplineService $service,  $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        return [
            'version' => '1.0.0',
        ];
    }



    public function verbs()
    {
        return [
            'index' => ["GET"],
            'dataExport' => ["POST"],
      ];
   }
}
