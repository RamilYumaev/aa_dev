<?php

namespace frontend\controllers;

use frontend\components\redirect\actions\ErrorAction;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    const LOG_FILE_PATH_NAME = '@frontendRuntime/logs/app.log';

    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['clear-cache', 'log-view', 'app-log-clear'],
                'rules' => [
                    [
                        'actions' => ['clear-cache', 'log-view', 'app-log-clear'],
                        'allow' => true,
                        'roles' => ['dev'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionAntiDdos(){
        $this->layout = "@frontend/views/layouts/contentOnly.php";
        if(Yii::$app->request->post()){
            $cookies = Yii::$app->response->cookies;
            $cookies->add(new \yii\web\Cookie([
                'name' => 'cookieAntiDdos',
                'value' => Yii::$app->security->generateRandomString(),
            ]));

            return $this->redirect(['index']);
        }
        return $this->render('anti-ddos');
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "@frontend/views/layouts/frontPage.php";
        return $this->render('index');
    }

    public function actionClearCache()
    {
        $frontendAssets = Yii::getAlias("@frontend") . "/web/assets";
        $backendAssets = Yii::getAlias("@backend") . "/web/assets";

        self::removeDir($frontendAssets);
        self::removeDir($backendAssets);

        return "Папки assets очищены";
    }

    public function actionLogView()
    {
        $logFile = \Yii::getAlias(self::LOG_FILE_PATH_NAME);
        return $this->render('log-view', ['logFile' => $logFile]);
    }

    public function actionAppLogClear()
    {
        $logFile = \Yii::getAlias(self::LOG_FILE_PATH_NAME);
        \file_put_contents($logFile, '');

        return $this->redirect(['log-view']);
    }

    private static function removeDir($dir)
    {
        foreach (\glob($dir . '/*') as $file) {
            if (\is_dir($file)) {
                self::removeDir($file);
            } else {
                \unlink($file);
            }
        }
    }
}
