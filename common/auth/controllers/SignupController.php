<?php

namespace common\auth\controllers;

use common\auth\actions\traits\SigUpTrait;
use yii\web\Controller;

class SignupController extends Controller
{
    use SigUpTrait;
}