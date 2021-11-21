<?php
namespace modules\student\controllers\api;

use dictionary\helpers\DictFacultyHelper;
use modules\student\helpers\TypeHelper;
use yii\rest\Controller;


class DefaultController extends Controller
{
    public function verbs()
    {
        return [
            'index' => ['GET'],
            'faculty-list' => ['GET'],
            'type-list' => ['GET'],
        ];
    }

    public function actionIndex()
    {
        return [
            'version' => '1.0.0',
        ];
    }

    public function actionFacultyList()
    {
        return DictFacultyHelper::facultyList();
    }

    public function actionTypeList()
    {
        return TypeHelper::typeList();
    }
}
