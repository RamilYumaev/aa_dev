<?php

namespace modules\entrant;

use modules\entrant\components\UserNoJobEntrant;
use yii\base\Module;
use yii\filters\AccessControl;

class ApiEntrant extends Module
{
    public $controllerNamespace = 'modules\entrant\controllers\api';
}