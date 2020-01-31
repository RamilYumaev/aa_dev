<?php

namespace common\auth\controllers;

use common\auth\actions\traits\ResetPasswordTrait;
use yii\web\Controller;

class ResetController extends Controller
{
    use ResetPasswordTrait;
}